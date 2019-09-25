<?php


namespace PriceObservatoryCR\Controller;


use PriceObservatoryCR\Form\FeedManagementForm;
use PriceObservatoryCR\Model\PriceobservatorycrFeedQuery;
use PriceObservatoryCR\PriceObservatoryCR;
use Thelia\Controller\Admin\BaseAdminController;
use Thelia\Core\Security\AccessManager;
use Thelia\Core\Security\Resource\AdminResources;

class FeedConfigController extends BaseAdminController
{
    public function addFeedAction()
    {
        if (null !== $response = $this->checkAuth(array(AdminResources::MODULE), array('PriceObservatoryCR'), AccessManager::CREATE)) {
            return $response;
        }

        return $this->addOrUpdateFeed();
    }

    public function updateFeedAction()
    {
        if (null !== $response = $this->checkAuth(array(AdminResources::MODULE), array('PriceObservatoryCR'), AccessManager::UPDATE)) {
            return $response;
        }

        return $this->addOrUpdateFeed();
    }

    protected function addOrUpdateFeed()
    {
        $form = new FeedManagementForm($this->getRequest());

        try {
            $formData = $this->validateForm($form)->getData();

            $feed = PriceobservatorycrFeedQuery::create()
                ->filterById($formData['id'])
                ->findOneOrCreate();

            $feed->setLabel($formData['feed_label'])
                ->setLangId($formData['lang_id'])
                ->setCurrencyId($formData['currency_id'])
                ->setCountryId($formData['country_id'])
                ->save();

        } catch (\Exception $e) {
            $message = null;
            $message = $e->getMessage();
            $this->setupFormErrorContext(
                $this->getTranslator()->trans("PriceObservatoryCR configuration", [], PriceObservatoryCR::DOMAIN_NAME),
                $message,
                $form,
                $e
            );
        }

        return $this->generateRedirectFromRoute(
            "admin.module.configure",
            array(),
            array(
                'module_code' => 'PriceObservatoryCR',
                'current_tab' => 'feeds'
            )
        );
    }

    public function deleteFeedAction()
    {
        if (null !== $response = $this->checkAuth(array(AdminResources::MODULE), array('PriceObservatoryCR'), AccessManager::DELETE)) {
            return $response;
        }

        $feedId = $this->getRequest()->request->get('id_feed_to_delete');

        $feed = PriceobservatorycrFeedQuery::create()->findOneById($feedId);
        if ($feed != null) {
            $feed->delete();
        }

        return $this->generateRedirectFromRoute(
            "admin.module.configure",
            array(),
            array(
                'module_code' => 'PriceObservatoryCR',
                'current_tab' => 'feeds'
            )
        );
    }
}