<?php

return array(
    'view_manager' => array(
        'template_map' => array(
            'enrise/workbench/index' => __DIR__ . '/../view/workbench/index.phtml',
            'enrise/workbench/index/resource' => __DIR__ . '/../view/workbench/html/resource.phtml',
            'enrise/workbench/proxy' => __DIR__ . '/../view/workbench/proxy.phtml',
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
        )
    ),

    'router' => array(
        'routes' => array(
            'enrise-apigility-workbench' => array(
                'type'  => 'literal',
                'options' => array(
                    'route' => '/workbench',
                    'defaults' => array(
                        'controller' => 'Enrise\Apigility\Workbench\Controller\Workbench',
                        'action'     => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'apiproxy' => array(
                        'type' => 'literal',
                        'options' => array(
                            'route' => '/proxy',
                            'defaults' => array(
                                'action' => 'proxy'
                            )
                        )
                    )
                )
            )
        )
    ),
    'service_manager' => array(
        'services' => array(
            'ApigilityWorkbenchHttpClient' => new Zend\Http\Client(),
            'ApiRequestBuilder' => new Enrise\Apigility\Workbench\Model\ApiRequestBuilder(),
            'HttpResponseSerializer' => new Enrise\Apigility\Workbench\Model\HttpResponseSerializer()
        )
    ),
    'apigility-workbench' => array(
        'httpclient' => array(
            'useragent' => 'Enrise Apigility Workbench',
            'adapter' => 'Zend\\Http\\Client\\Adapter\\Curl'
        )
    )
);
