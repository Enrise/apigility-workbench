<?php

namespace Enrise\Apigility\Workbench\Controller;

use Zend\Http\Request;
use Zend\Mvc\Controller\AbstractActionController;
use Enrise\Apigility\Workbench\Model\ModuleModel;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\View\Model\ViewModel;


class WorkbenchController extends AbstractActionController implements ServiceLocatorAwareInterface
{
    protected $moduleModel;
    /**
     * @var ServiceLocatorInterface
     */
    protected $services;

    public function __construct(ModuleModel $moduleModel)
    {
        $this->moduleModel = $moduleModel;
    }

    public function indexAction()
    {
        $view = new ViewModel();
        $view->entrypoints = $this->moduleModel->getEntryPoints($this->getServiceLocator());
        return $view;
    }

    public function proxyAction()
    {
        var_dump($_POST); die();

        /** @var \Zend\Http\Request $request */
        $request = $this->getRequest();

        $apiRequest = new Request();
        $httpClient = $this->getHttpClient()->setRequest($apiRequest);
    }

    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->services = $serviceLocator;
    }

    /**
     * @return ServiceLocatorInterface
     */
    public function getServiceLocator()
    {
        return $this->services;
    }

    /**
     * @return \Zend\Http\Client
     */
    protected function getHttpClient()
    {
        $serviceLocator = $this->getServiceLocator();
        $config = $serviceLocator->get('Config');

        /** @var \Zend\Http\Client $httpClient */
        $httpClient = $serviceLocator->get('ApigilityWorkbenchHttpClient');
        $httpClient->setOptions($config['apigility-workbench']['httpclient']);
        return $httpClient;
    }
}
