<?php

namespace Enrise\Apigility\Workbench\Controller;

use Enrise\Apigility\Workbench\Filter\ProxyInputFilter;
use Enrise\Apigility\Workbench\Model\ApiRequestBuilder;
use Zend\Mvc\Controller\AbstractActionController;
use Enrise\Apigility\Workbench\Model\ModuleModel;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Http\Client;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;


class WorkbenchController extends AbstractActionController
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
        $viewModel = new JsonModel();

        /** @var \Zend\Http\Request $request */
        $request = $this->getRequest();

        $filter = new ProxyInputFilter();
        if ($request->isPost()) {
            $filter->setData($request->getPost());
            if (!$filter->isValid()) {
                // bail!
                $viewModel->setVariables(
                    array(
                        'error' => true,
                        'message' => 'The required parameters have not been set or are not valid.',
                        'detailMessages' => $filter->getMessages()
                    )
                );

                return $viewModel;
            }
        }

        // build proxy call
        /** @var Client $apiClient */
        $apiClient = $this->getServiceLocator()->get('ApigilityWorkbenchHttpClient');

        /** @var ApiRequestBuilder $requestBuilder */
        $requestBuilder = $this->getServiceLocator()->get('ApiRequestBuilder');

        $apiRequest = $requestBuilder->fromProxyRequest($request);

        // respond
        $response = $apiClient->dispatch($apiRequest);
        $serializer = $this->getServiceLocator()->get('HttpResponseSerializer');
        $serializer->setResponse($response);

        $viewModel->setVariable('response', $serializer->serialize());

        return $viewModel;
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
