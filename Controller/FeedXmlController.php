<?php

namespace PriceObservatoryCR\Controller;

use ClassicRide\Model\ProductSaleElementsPurchaseQuery;
use PriceObservatoryCR\Events\IsItemValidEvent;
use PriceObservatoryCR\Model\PriceobservatorycrFeed;
use PriceObservatoryCR\Model\PriceobservatorycrFeedQuery;
use PriceObservatoryCR\Tools\GtinChecker;
use PriceObservatoryCR\Model\PriceobservatorycrLogQuery;
use PriceObservatoryCR\PriceObservatoryCR;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\Propel;
use Thelia\Action\Image;
use Thelia\Controller\Front\BaseFrontController;
use Thelia\Core\Event\Image\ImageEvent;
use Thelia\Core\HttpFoundation\Response;
use Thelia\Core\Translation\Translator;
use Thelia\Model\AreaDeliveryModuleQuery;
use Thelia\Model\CategoryI18nQuery;
use Thelia\Model\ConfigQuery;
use Thelia\Model\Module;
use Thelia\Model\ModuleQuery;
use Thelia\Model\OrderPostage;
use Thelia\Model\TaxRule;
use Thelia\Model\TaxRuleQuery;
use Thelia\Module\BaseModule;
use Thelia\TaxEngine\Calculator;
use Thelia\Tools\MoneyFormat;
use Thelia\Tools\URL;

class FeedXmlController extends BaseFrontController
{
    /**
     * @var PriceobservatorycrLogQuery $logger
     */
    private $logger;

    private $ean_rule;

    private $nb_pse;
    private $nb_pse_invisible;
    private $nb_pse_error;

    const EAN_RULE_ALL = "all";
    const EAN_RULE_CHECK_FLEXIBLE = "check_flexible";
    const EAN_RULE_CHECK_STRICT = "check_strict";
    const EAN_RULE_NONE = "none";

    const DEFAULT_EAN_RULE = self::EAN_RULE_CHECK_STRICT;

    public function getFeedXmlAction($feedId)
    {
        $this->logger = PriceobservatorycrLogQuery::create();
        $this->ean_rule = PriceObservatoryCR::getConfigValue("ean_rule", self::DEFAULT_EAN_RULE);

        $feed = PriceobservatorycrFeedQuery::create()->findOneById($feedId);

        $request = $this->getRequest();

        $limit = $request->get('limit', null);
        $offset = $request->get('offset', null);

        if ($feed == null) {
            $this->pageNotFound();
        }

        try {
            $shippingArray = $this->buildShippingArray($feed);

            $pseArray = $this->getProductItems($feed, $limit, $offset);
//            $pseArray = $this->getProductItems($feed, 1000, $offset);
            $this->injectUrls($pseArray, $feed);
            $this->injectTaxedPrices($pseArray, $feed);
            //$this->injectAttributesInTitle($pseArray, $feed);
            $this->injectImages($pseArray);

            $this->nb_pse = 0;
            $this->nb_pse_invisible = 0;
            $this->nb_pse_error = 0;
            $content = $this->renderXmlAll($feed, $pseArray, $shippingArray);

            if ($this->nb_pse_invisible > 0) {
                $this->logger->logInfo(
                    $feed,
                    null,
                    Translator::getInstance()->trans('%nb product item(s) have been skipped because they were set as not visible or didn\'t have their top parameter set as 1.', ['%nb' => $this->nb_pse_invisible], PriceObservatoryCR::DOMAIN_NAME),
                    Translator::getInstance()->trans('You can set your products visibility in the product edit tool by checking the box [This product is online].', [], PriceObservatoryCR::DOMAIN_NAME)
                );
            }

            if ($this->nb_pse_error > 0) {
                $this->logger->logInfo(
                    $feed,
                    null,
                    Translator::getInstance()->trans('%nb product item(s) have been skipped because of errors.', ['%nb' => $this->nb_pse_error], PriceObservatoryCR::DOMAIN_NAME),
                    Translator::getInstance()->trans('Check the ERROR messages below to get further details about the error.', [], PriceObservatoryCR::DOMAIN_NAME)
                );
            }

            if ($this->nb_pse <= 0) {
                $this->logger->logFatal(
                    $feed,
                    null,
                    Translator::getInstance()->trans('No valid products with a \'Top\' value of 1 have been found', [], PriceObservatoryCR::DOMAIN_NAME),
                    Translator::getInstance()->trans('Your products may not have been included due to errors. Check the others messages in this log.', [], PriceObservatoryCR::DOMAIN_NAME)
                );
            } else {
                $nb_line_xml = substr_count($content, PHP_EOL);
                if ($nb_line_xml <= 8) {
                    $this->logger->logFatal(
                        $feed,
                        null,
                        Translator::getInstance()->trans('Empty generated XML file', [], PriceObservatoryCR::DOMAIN_NAME),
                        Translator::getInstance()->trans('Your products may not have been included due to errors. Check the others messages in this log.', [], PriceObservatoryCR::DOMAIN_NAME)
                    );
                } else {
                    $this->logger->logSuccess($feed, null, Translator::getInstance()->trans('The XML file has been successfully generated with %nb product items.', ['%nb' => $this->nb_pse], PriceObservatoryCR::DOMAIN_NAME));
                }
            }

            $response = new Response();
            $response->setContent($content);
            $response->headers->set('Content-Type', 'application/xml');

            return $response;

        } catch (\Exception $ex) {
            $this->logger->logFatal($feed, null, $ex->getMessage(), $ex->getFile() . " at line " . $ex->getLine());
            throw $ex;
        }
    }

    protected function renderXmlAll($feed, &$pseArray, $shippingArray)
    {
        $checkAvailability = ConfigQuery::checkAvailableStock();

        $str = '<?xml version="1.0"?>' . PHP_EOL;
        $str .= '<rss xmlns="http://base.google.com/ns/1.0" version="2.0">' . PHP_EOL;
        $str .= '<catalogue language="FR" GMT="+1" date="' . date('F d, Y, H:i a') . '" encoding="UTF-8" country="FR" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">' . PHP_EOL;
//xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"

        $shippingStr = '';
        foreach ($shippingArray as $shipping) {
            $shippingStr .= '<service>' . $shipping['service'] . '</service>' . PHP_EOL;
            $formattedPrice = MoneyFormat::getInstance($this->getRequest())->formatStandardNumber($shipping['price'], '2');
            $shippingStr .= '<cout_livraison>' . $formattedPrice . '</cout_livraison>' . PHP_EOL;
        }

        $i = 0;
        foreach ($pseArray as &$pse) {
            if ($i == 1000) {
                break;
            }
            $isItemValidEvent = new IsItemValidEvent($feed, $pse['ID']);
            $hasTopElement = ProductSaleElementsPurchaseQuery::create()
                ->findOneByProductSaleElementsId($pse['ID']);

            if ($hasTopElement) {
                if ($pse['PRODUCT_VISIBLE'] == 1 && $isItemValidEvent->isValid() && $hasTopElement->getTop() == 1) {
                    $xmlPse = $this->renderXmlOnePse($feed, $pse, $shippingStr, $checkAvailability);
                    if (!empty($xmlPse)) {
                        $this->nb_pse++;
                        $i++;
                    } else {
                        $this->nb_pse_error++;
                    }
                    $str .= $xmlPse;
                } else {
                    $this->nb_pse_invisible++;
                }
            }
        }


        $str .= '</catalogue>' . PHP_EOL;
        $str .= '</rss>';
        return $str;
    }

    /**
     * @param PriceobservatorycrFeed $feed
     * @param array $pse
     * @param string $shippingStr
     * @param bool $checkAvailability
     * @return string
     */
    protected function renderXmlOnePse($feed, &$pse, $shippingStr, $checkAvailability)
    {
        $str = '<produit>' . PHP_EOL;


        // **************** Title ****************

        if (empty($pse['TITLE'])) {
            $this->logger->logError(
                $feed,
                $pse['ID'],
                Translator::getInstance()->trans('Missing product title for the language "%lang"', ['%lang' => $feed->getLang()->getTitle()], PriceObservatoryCR::DOMAIN_NAME),
                Translator::getInstance()->trans('Check that this product has a valid title in this langage.', [], PriceObservatoryCR::DOMAIN_NAME)
            );
            return '';
        }

        $str .= '<modele>' . $this->xmlSafeEncode($pse['TITLE']) . '</modele>' . PHP_EOL;


        // **************** Description ****************

        $description = html_entity_decode(trim(strip_tags($pse['DESCRIPTION'])));

        if (empty($description)) {
            $this->logger->logWarning(
                $feed,
                $pse['ID'],
                Translator::getInstance()->trans('Missing product description for the language "%lang"', ['%lang' => $feed->getLang()->getTitle()], PriceObservatoryCR::DOMAIN_NAME),
                Translator::getInstance()->trans('Check that this product has a valid description in this language.', [], PriceObservatoryCR::DOMAIN_NAME)
            );
            $str .= '<description>' . ' ' . '</description>' . PHP_EOL;
        } else {
            $str .= '<description>' . $this->xmlSafeEncode($description) . '</description>' . PHP_EOL;
        }


        // **************** ID / SKU ****************

        //$str .= '<id>'.$pse['ID'].'</id>'.PHP_EOL;
        if (empty($pse['REF_PRODUCT'])) {
            $this->logger->logError(
                $feed,
                $pse['ID'],
                Translator::getInstance()->trans('Missing product REF', [], PriceObservatoryCR::DOMAIN_NAME)
            );
            return '';
        }

        $str .= '<sku>' . $this->xmlSafeEncode($pse['REF_PRODUCT']) . '</sku>' . PHP_EOL;


        // **************** URL ****************

        if (empty($pse['URL'])) {
            $this->logger->logWarning(
                $feed,
                $pse['ID'],
                Translator::getInstance()->trans('Missing product URL', [], PriceObservatoryCR::DOMAIN_NAME)
            );
            $str .= '<url>' . ' ' . '</url>' . PHP_EOL;
        } else {
            $str .= '<url>' . $this->xmlSafeEncode($pse['URL']) . '</url>' . PHP_EOL;
        }


        // **************** MPN ****************

        $str .= '<mpn>' . ' ' . '</mpn>' . PHP_EOL;


        // **************** EAN / GTIN code ****************

        $include_ean = false;

        if (empty($pse['EAN_CODE']) || $this->ean_rule == self::EAN_RULE_NONE) {
            $include_ean = false;
        } elseif ($this->ean_rule == self::EAN_RULE_ALL) {
            $include_ean = true;
        } else {
            if ((new GtinChecker())->isValidGtin($pse['EAN_CODE'])) {
                $include_ean = true;
            } else {
                if ($this->ean_rule == self::EAN_RULE_CHECK_FLEXIBLE) {
                    $include_ean = false;
                } elseif ($this->ean_rule == self::EAN_RULE_CHECK_STRICT) {
                    $this->logger->logWarning(
                        $feed,
                        $pse['ID'],
                        Translator::getInstance()->trans('Invalid GTIN/EAN code : "%code"', ["%code" => $pse['EAN_CODE']], PriceObservatoryCR::DOMAIN_NAME),
                        Translator::getInstance()->trans('The product s identification code seems invalid. You can set a valid EAN code in the Edit product page.', [], PriceObservatoryCR::DOMAIN_NAME)
                    );
                    $include_ean = false;
                }
            }
        }

        if ($include_ean) {
            $str .= '<ean13>' . $pse['EAN_CODE'] . '</ean13>' . PHP_EOL;
        } else {
            $str .= '<ean13>' . ' ' . '</ean13>' . PHP_EOL;
        }

//        $str .= '<g:item_group_id>'.$pse['REF_PRODUCT'].'</g:item_group_id>'.PHP_EOL;


        // **************** Brand ****************

        if (empty($pse['BRAND_TITLE'])) {
            $this->logger->logWarning(
                $feed,
                $pse['ID'],
                Translator::getInstance()->trans('Missing product brand for the language "%lang"', ['%lang' => $feed->getLang()->getTitle()], PriceObservatoryCR::DOMAIN_NAME),
                Translator::getInstance()->trans('The product has no brand or the brand doesn t have a title in this language.', [], PriceObservatoryCR::DOMAIN_NAME)
            );
            $str .= '<marque>' . ' ' . '</marque>' . PHP_EOL;
        } else {
            $str .= '<marque>' . $this->xmlSafeEncode($pse['BRAND_TITLE']) . '</marque>' . PHP_EOL;
        }


        // **************** Shipping cost ****************

        $str .= $shippingStr;


        // **************** Category ****************

        if (empty($pse['CATEGORY_ID'])) {
            $this->logger->logWarning(
                $feed,
                $pse['ID'],
                Translator::getInstance()->trans('Missing product Category', [], PriceObservatoryCR::DOMAIN_NAME)
            );
            $str .= '<categorie>' . ' ' . '</categorie>' . PHP_EOL;
        } else {
            $categoryLocalized = CategoryI18nQuery::create()
                ->filterByLocale('fr_FR')
                ->findOneById($pse['CATEGORY_ID']);
            $str .= '<categorie>' . $this->xmlSafeEncode($categoryLocalized->getTitle()) . '</categorie>' . PHP_EOL;
        }


        // **************** Price ****************

        if (empty($pse['TAXED_PRICE'])) {
            $this->logger->logWarning(
                $feed,
                $pse['ID'],
                Translator::getInstance()->trans('Missing product price for the currency "%code"', ['%code' => $feed->getCurrency()->getCode()], PriceObservatoryCR::DOMAIN_NAME),
                Translator::getInstance()->trans('Unable to compute a price for this product and this currency. Specify one manually or check [Apply exchange rates] in the Edit Product page for this currency.', [], PriceObservatoryCR::DOMAIN_NAME)
            );
            $str .= '<prix_ttc>' . ' ' . '</prix_ttc>' . PHP_EOL;

        } else {
            $formattedTaxedPrice = MoneyFormat::getInstance($this->getRequest())->formatStandardNumber($pse['TAXED_PRICE'], 2);//$feed->getCurrencyId());

            $str .= '<prix_ttc>' . $formattedTaxedPrice . '</prix_ttc>' . PHP_EOL;
        }


        if (!empty($pse['TAXED_PROMO_PRICE']) && $pse['TAXED_PROMO_PRICE'] < $pse['TAXED_PRICE']) {
            $formattedTaxedPromoPrice = MoneyFormat::getInstance($this->getRequest())->formatStandardNumber($pse['TAXED_PROMO_PRICE'], 2);//$feed->getCurrencyId());
            $str .= '<prix_promo_ttc>' . $formattedTaxedPromoPrice . '</prix_promo_ttc>' . PHP_EOL;
        } else {
            $str .= '<prix_promo_ttc>' . ' ' . '</prix_promo_ttc>' . PHP_EOL;
        }


        // **************** Image path ****************

        if (empty($pse['IMAGE_PATH'])) {
            $this->logger->logWarning(
                $feed,
                $pse['ID'],
                Translator::getInstance()->trans('Missing product image', [], PriceObservatoryCR::DOMAIN_NAME)
            );
            $str .= '<img>' . ' ' . '</img>' . PHP_EOL;
        } else {
            $str .= '<img>' . $this->xmlSafeEncode($pse['IMAGE_PATH']) . '</img>' . PHP_EOL;

        }


        return $str . '</produit>' . PHP_EOL;
    }

    protected function xmlSafeEncode($str)
    {
        return htmlspecialchars($str, ENT_XML1);
    }

    protected function hasCustomField($pse, $fieldName)
    {
        foreach ($pse['CUSTOM_FIELD_ARRAY'] as $field) {
            if ($field['FIELD_NAME'] == $fieldName) {
                return true;
            }
        }
        return false;
    }

    /**
     * @param PriceobservatorycrFeed $feed
     */
    protected function getProductItems($feed, $limit = null, $offset = null)
    {
        $sql = 'SELECT 

                pse.ID AS ID,
                product.ID AS ID_PRODUCT,
                product.REF AS REF_PRODUCT,
                product.VISIBLE AS PRODUCT_VISIBLE,
                product_i18n.TITLE AS TITLE,
                product_i18n.DESCRIPTION AS DESCRIPTION,
                COALESCE (brand_i18n_with_locale.TITLE, brand_i18n_without_locale.TITLE) AS BRAND_TITLE,
                pse.QUANTITY AS QUANTITY,
                pse.EAN_CODE AS EAN_CODE,
                product_category.CATEGORY_ID AS CATEGORY_ID,
                product.TAX_RULE_ID AS TAX_RULE_ID,
                COALESCE(price_on_currency.PRICE, CASE WHEN NOT ISNULL(price_default.PRICE) THEN ROUND(price_default.PRICE * :currate, 2) END) AS PRICE,
                COALESCE(price_on_currency.PROMO_PRICE, CASE WHEN NOT ISNULL(price_default.PROMO_PRICE) THEN ROUND(price_default.PROMO_PRICE * :currate, 2) END) AS PROMO_PRICE,
                rewriting_url.URL AS REWRITTEN_URL,
                COALESCE(product_image_on_pse.FILE, product_image_default.FILE) AS IMAGE_NAME
                
                FROM product_sale_elements AS pse
                
                INNER JOIN product ON (pse.PRODUCT_ID = product.ID)
                LEFT OUTER JOIN product_price price_on_currency ON (pse.ID = price_on_currency.PRODUCT_SALE_ELEMENTS_ID AND price_on_currency.CURRENCY_ID = :currid)
                LEFT OUTER JOIN product_price price_default ON (pse.ID = price_default.PRODUCT_SALE_ELEMENTS_ID AND price_default.FROM_DEFAULT_CURRENCY = 1)
                LEFT OUTER JOIN product_category ON (pse.PRODUCT_ID = product_category.PRODUCT_ID AND product_category.DEFAULT_CATEGORY = 1)
                LEFT OUTER JOIN product_i18n ON (pse.PRODUCT_ID = product_i18n.ID AND product_i18n.LOCALE = :locale)
                LEFT OUTER JOIN brand_i18n brand_i18n_with_locale ON (product.BRAND_ID = brand_i18n_with_locale.ID AND brand_i18n_with_locale.LOCALE = :locale)
                LEFT OUTER JOIN brand_i18n brand_i18n_without_locale ON (product.BRAND_ID = brand_i18n_without_locale.ID)
                LEFT OUTER JOIN rewriting_url ON (pse.PRODUCT_ID = rewriting_url.VIEW_ID AND rewriting_url.view = \'product\' AND rewriting_url.view_locale = :locale AND rewriting_url.redirected IS NULL)
                LEFT OUTER JOIN product_sale_elements_product_image pse_image ON (pse.ID = pse_image.PRODUCT_SALE_ELEMENTS_ID)
                LEFT OUTER JOIN product_image product_image_default ON (pse.PRODUCT_ID = product_image_default.PRODUCT_ID AND product_image_default.POSITION = 1)
                LEFT OUTER JOIN product_image product_image_on_pse ON (product_image_on_pse.ID = pse_image.PRODUCT_IMAGE_ID)
                LEFT OUTER JOIN product_sale_elements_purchase ON (product_sale_elements_purchase.`product_sale_elements_id` = pse.id)
                
                WHERE product_sale_elements_purchase.top = 1

                GROUP BY product.ID';

        $limit = $this->checkPositiveInteger($limit);
        $offset = $this->checkPositiveInteger($offset);

        if ($limit) {
            $sql .= " LIMIT $limit";
        }

        if ($offset) {
            if (!$limit) {
                $sql .= " LIMIT 99999999999";
            }
            $sql .= " OFFSET $offset";
        }

        $con = Propel::getConnection();
        $stmt = $con->prepare($sql);
        $stmt->bindValue(':locale', $feed->getLang()->getLocale(), \PDO::PARAM_STR);
        $stmt->bindValue(':currid', $feed->getCurrencyId(), \PDO::PARAM_INT);
        $stmt->bindValue(':currate', $feed->getCurrency()->getRate(), \PDO::PARAM_STR);

        $stmt->execute();
        $pseArray = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return $pseArray;
    }

    protected function checkPositiveInteger($var)
    {
        $var = filter_var($var, FILTER_VALIDATE_INT);
        return ($var !== false && $var >= 0) ? $var : null;
    }

    protected function recursiveSetCategoryPath(&$theliaCategories, $categoryRow)
    {
        if ($categoryRow['PARENT'] == 0 || $categoryRow['PATH'] != null || $categoryRow['TITLE'] == null) {
            if ($categoryRow['PARENT'] == 0 && $categoryRow['PATH'] == null && $categoryRow['TITLE'] != null) {
                $theliaCategories[$categoryRow['ID']]['PATH'] = $categoryRow['TITLE'];
            }
            return;
        }

        $parentRow = $theliaCategories[$categoryRow['PARENT']];

        if ($parentRow['PATH'] == null) {
            $this->recursiveSetCategoryPath($theliaCategories, $parentRow);
            $parentRow = $theliaCategories[$categoryRow['PARENT']];
        }

        if ($parentRow['PATH'] != null) {
            $theliaCategories[$categoryRow['ID']]['PATH'] = $parentRow['PATH'] . ' > ' . $categoryRow['TITLE'];
        }
    }


    /**
     * @param PriceobservatorycrFeed $feed
     * @param array $pseArray
     */
    protected function injectUrls(&$pseArray, $feed)
    {
        $urlManager = URL::getInstance();
        foreach ($pseArray as &$pse) {
            if ($pse['REWRITTEN_URL'] == null) {
                $pse['URL'] = $urlManager->retrieve('product', $pse['ID_PRODUCT'], $feed->getLang()->getLocale())->toString();
            } else {
                $pse['URL'] = $urlManager->absoluteUrl($pse['REWRITTEN_URL']);
            }
        }
    }


    /**
     * @param PriceobservatorycrFeed $feed
     * @param array $pseArray
     */
    protected function injectTaxedPrices(&$pseArray, $feed)
    {
        $taxRulesCollection = TaxRuleQuery::create()->find();
        $taxRulesArray = [];
        /** @var TaxRule $taxRule * */
        foreach ($taxRulesCollection as $taxRule) {
            $taxRulesArray[$taxRule->getId()] = $taxRule;
        }

        $taxCalculatorsArray = [];

        foreach ($pseArray as &$pse) {
            $taxRuleId = $pse['TAX_RULE_ID'];
            $taxRule = $taxRulesArray[$taxRuleId];

            if (!array_key_exists($taxRuleId, $taxCalculatorsArray)) {
                $calculator = new Calculator();
                $calculator->loadTaxRuleWithoutProduct($taxRule, $feed->getCountry());
                $taxCalculatorsArray[$taxRuleId] = $calculator;
            } else {
                $calculator = $taxCalculatorsArray[$taxRuleId];
            }

            $pse['TAXED_PRICE'] = !empty($pse['PRICE']) ? $calculator->getTaxedPrice($pse['PRICE']) : null;
            $pse['TAXED_PROMO_PRICE'] = !empty($pse['PROMO_PRICE']) ? $calculator->getTaxedPrice($pse['PROMO_PRICE']) : null;
        }
    }

    /**
     * @param PriceobservatorycrFeed $feed
     * @param array $pseArray
     */
    protected function injectAttributesInTitle(&$pseArray, $feed)
    {
        $attributesConcatArray = $this->getArrayAttributesConcatValues($feed->getLang()->getLocale(), null, ' - ');
        foreach ($pseArray as &$pse) {
            if (array_key_exists($pse['ID'], $attributesConcatArray)) {
                $pse['TITLE'] .= ' - ' . $attributesConcatArray[$pse['ID']];
            }
        }
    }


    /**
     * @param array $pseArray
     */
    protected function injectImages(&$pseArray)
    {
        foreach ($pseArray as &$pse) {
            if ($pse['IMAGE_NAME'] != null) {
                $imageEvent = $this->createImageEvent($pse['IMAGE_NAME'], 'product');
                //$this->dispatch(TheliaEvents::IMAGE_PROCESS, $imageEvent);
                $pse['IMAGE_PATH'] = $imageEvent->getFileUrl();
//TESTING//                $pse['IMAGE_PATH'] = 'visiere-bell-custom-500-3-snap-shield-dark-smoke-fume-fonce-ecran-pressions-15293.jpg';
            } else {
                $pse['IMAGE_PATH'] = null;
            }
        }
    }


    /**
     * @param string $imageFile
     * @param string $type
     * @return ImageEvent
     */
    protected function createImageEvent($imageFile, $type)
    {
        $imageEvent = new ImageEvent();
        $baseSourceFilePath = ConfigQuery::read('images_library_path');
        if ($baseSourceFilePath === null) {
            $baseSourceFilePath = THELIA_LOCAL_DIR . 'media' . DS . 'images';
        } else {
            $baseSourceFilePath = THELIA_ROOT . $baseSourceFilePath;
        }
        // Put source image file path
        $sourceFilePath = sprintf(
            '%s/%s/%s',
            $baseSourceFilePath,
            $type,
            $imageFile
        );
        $imageEvent->setSourceFilepath($sourceFilePath);
        $imageEvent->setCacheSubdirectory($type);
        $imageEvent->setResizeMode(Image::EXACT_RATIO_WITH_BORDERS);
        return $imageEvent;
    }


    protected function getArrayAttributesConcatValues($locale, $attribute_id = null, $separator = '/')
    {
        $con = Propel::getConnection();

        $sql = 'SELECT attribute_combination.product_sale_elements_id AS PSE_ID, GROUP_CONCAT(attribute_av_i18n.title SEPARATOR \'' . $separator . '\') AS CONCAT FROM attribute_combination
                INNER JOIN attribute_av_i18n ON (attribute_combination.attribute_av_id = attribute_av_i18n.id)
                WHERE attribute_av_i18n.locale = :locale';

        if ($attribute_id != null) {
            $sql .= ' AND attribute_combination.attribute_id = :attrid';
        }

        $sql .= ' GROUP BY attribute_combination.product_sale_elements_id';

        $stmt = $con->prepare($sql);
        $stmt->bindValue(':locale', $locale, \PDO::PARAM_STR);
        if ($attribute_id != null) {
            $stmt->bindValue(':attrid', $attribute_id, \PDO::PARAM_INT);
        }

        $stmt->execute();
        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $attrib_by_pse = array();
        foreach ($rows as $row) {
            $attrib_by_pse[$row['PSE_ID']] = $row['CONCAT'];
        }
        return $attrib_by_pse;
    }


    protected function getArrayFeaturesConcatValues($locale, $feature_id)
    {
        $con = Propel::getConnection();

        $sql = 'SELECT feature_product.product_id AS PRODUCT_ID, GROUP_CONCAT(feature_av_i18n.title SEPARATOR \'/\') AS CONCAT FROM feature_product
                INNER JOIN feature_av_i18n ON (feature_product.feature_av_id = feature_av_i18n.id)
                WHERE feature_av_i18n.locale = :locale
                AND feature_product.feature_id = :featid
                GROUP BY feature_product.product_id';

        $stmt = $con->prepare($sql);
        $stmt->bindValue(':locale', $locale, \PDO::PARAM_STR);
        $stmt->bindValue(':featid', $feature_id, \PDO::PARAM_INT);

        $stmt->execute();
        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $attrib_by_pse = array();
        foreach ($rows as $row) {
            $attrib_by_pse[$row['PRODUCT_ID']] = $row['CONCAT'];
        }
        return $attrib_by_pse;
    }

    /**
     * @param PriceobservatorycrFeed $feed
     * @return array
     */
    protected function buildShippingArray($feed)
    {
        $resultArray = [];

        $shippingInfoArray = $this->getShippings($feed);

        foreach ($shippingInfoArray as $moduleTitle => $postagePrice) {
            $shippingItem = [];
            $shippingItem['country_code'] = $feed->getCountry()->getIsoalpha2();
            $shippingItem['service'] = $moduleTitle;
            $shippingItem['price'] = 0;
            $shippingItem['currency_id'] = $feed->getCurrencyId();
            $resultArray[] = $shippingItem;
        }

        if (empty($resultArray)) {
            $this->logger->logError(
                $feed,
                null,
                Translator::getInstance()->trans('No shipping informations.', [], PriceObservatoryCR::DOMAIN_NAME),
                Translator::getInstance()->trans('There is no shipping informations. Check that at least one delivery module covers the country used by your feed.', [], PriceObservatoryCR::DOMAIN_NAME)
            );
        }

        return $resultArray;
    }

    /**
     * @param PriceobservatorycrFeed $feed
     * @return array
     */
    protected function getShippings($feed)
    {
        $country = $feed->getCountry();

        $search = ModuleQuery::create()
            ->filterByActivate(1)
            ->filterByType(BaseModule::DELIVERY_MODULE_TYPE, Criteria::EQUAL)
            ->find();

        $deliveries = array();

        /** @var Module $deliveryModule */
        foreach ($search as $deliveryModule) {
            $deliveryModule->setLocale($feed->getLang()->getLocale());

            $areaDeliveryModule = AreaDeliveryModuleQuery::create()
                ->findByCountryAndModule($country, $deliveryModule);

            if (null === $areaDeliveryModule) {
                continue;
            }

            $moduleInstance = $deliveryModule->getDeliveryModuleInstance($this->container);

            if ($moduleInstance->isValidDelivery($country)) {
                $postage = OrderPostage::loadFromPostage($moduleInstance->getPostage($country));
                $price = $postage->getAmount() * $feed->getCurrency()->getRate();

                $deliveries[$deliveryModule->getTitle()] = $price;
            }
        }

        return $deliveries;
    }
}
