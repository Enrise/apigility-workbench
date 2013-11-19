<?php

namespace Enrise\Apigility\Workbench;

class Module
{
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__
                ),
            ),
        );
    }

    public function getServiceConfig()
    {
        return array('factories' => array(
            'Enrise\Apigility\Workbench\Model\ModuleModel' => function ($services) {
                    if (!$services->has('ModuleManager')) {
                        throw new ServiceNotCreatedException(
                            'Cannot create Enrise\Apigility\Workbench\Model\ModuleModel service because ModuleManager service is not present'
                        );
                    }
                    $modules    = $services->get('ModuleManager');
                    $restConfig = array();
                    $rpcConfig  = array();
                    if ($services->has('Config')) {
                        $config = $services->get('Config');
                        if (isset($config['zf-rest'])) {
                            $restConfig = $config['zf-rest'];
                        }
                        if (isset($config['zf-rpc'])) {
                            $rpcConfig = $config['zf-rpc'];
                        }
                    }
                    return new Model\ModuleModel($modules, $restConfig, $rpcConfig);
                },
        ));
    }

    public function getControllerConfig()
    {
        return array('factories' => array(
            'Enrise\Apigility\Workbench\Controller\Workbench' => function ($controllers) {
                    $services = $controllers->getServiceLocator();
                    $model    = $services->get('Enrise\Apigility\Workbench\Model\ModuleModel');
                    return new Controller\WorkbenchController($model);
                },
        ));
    }

    public function getConfig()
    {
        return include __DIR__ . '/../../../../config/module.config.php';
    }

    /**
     * @param  \Zend\Mvc\MvcEvent $e The MvcEvent instance
     * @return void
     */
    public function onBootstrap($e)
    {
        $app = $e->getApplication();
        $app->getEventManager()->attach('render', array($this, 'registerJsonStrategy'), 100);
    }

    /**
     * @param  \Zend\Mvc\MvcEvent $e The MvcEvent instance
     * @return void
     */
    public function registerJsonStrategy($e)
    {
        $app          = $e->getTarget();
        $locator      = $app->getServiceManager();
        $view         = $locator->get('Zend\View\View');
        $jsonStrategy = $locator->get('ViewJsonStrategy');

        $view->getEventManager()->attach($jsonStrategy, 100);
    }
}
