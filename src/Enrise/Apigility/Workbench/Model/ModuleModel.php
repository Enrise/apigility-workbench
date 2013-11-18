<?php
/**
 * Created by PhpStorm.
 * User: jvandijk
 * Date: 18/11/13
 * Time: 20:25
 */
namespace Enrise\Apigility\Workbench\Model;

use Zend\Di\ServiceLocator;
use ZF\Apigility\Admin\Model\ModuleModel as ApigilityModuleModel;
use Zend\ServiceManager\ServiceManager;

class ModuleModel extends ApigilityModuleModel
{
    public function getEntryPoints(ServiceManager $sm)
    {
        $config = $sm->get('config');

        $entrypoints = array();
        $modules = $this->getModules();
        foreach ($modules as $module) {
            $services = $module->getRestServices();
            foreach ($services as $service) {
                $entrypoints[$service]['config'] = $config['zf-rest'][$service];
                $entrypoints[$service]['route'] = $config['router']['routes'][$config['zf-rest'][$service]['route_name']];
                if (array_key_exists($service, $config['zf-content-negotiation']['content_type_whitelist'])) {
                    $entrypoints[$service]['content_type'] = $config['zf-content-negotiation']['content_type_whitelist'][$service];
                }
                if (array_key_exists($service, $config['zf-content-negotiation']['accept_whitelist'])) {
                    $entrypoints[$service]['accept'] = $config['zf-content-negotiation']['accept_whitelist'][$service];
                }
            }
        }
        return $entrypoints;
    }
}
