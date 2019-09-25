<?php

namespace PriceObservatoryCR\Controller;

use PriceObservatoryCR\PriceObservatoryCR;
use Propel\Runtime\Propel;
use Thelia\Controller\Admin\BaseAdminController;
use Thelia\Core\Security\AccessManager;
use Thelia\Core\Security\Resource\AdminResources;

class ModuleConfigController extends BaseAdminController
{
    public function viewConfigAction($params = array())
    {
        if (null !== $response = $this->checkAuth(array(AdminResources::MODULE), 'PriceObservatoryCR', AccessManager::VIEW)) {
            return $response;
        }

        $ean_rule = PriceObservatoryCR::getConfigValue("ean_rule", FeedXmlController::DEFAULT_EAN_RULE);

        return $this->render(
            "module-configuration-po",
            [
                'pse_count' => $this->getNumberOfPse(),
                'ean_rule' => $ean_rule
            ]
        );
    }

    protected function getNumberOfPse()
    {
        $sql = 'SELECT COUNT(*) AS nb FROM product_sale_elements';
        $stmt = Propel::getConnection()->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $rows[0]['nb'];
    }
}
