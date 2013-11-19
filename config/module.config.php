<?php

return array(
    'asset_manager' => array(
        'resolver_configs' => array(
            'paths' => array(
                __DIR__ . '/../asset',
            ),
        ),
    ),

    'view_manager' => array(
        'template_map' => array(
            'enrise/workbench/index' => __DIR__ . '/../view/workbench/index.phtml',
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
            'ApigilityWorkbenchHttpClient' => new Zend\Http\Client()
        )
    ),
    'apigility-workbench' => array(
        'httpclient' => array(
            'useragent' => 'Enrise Apigility Workbench',
            'adapter' => 'Zend\\Http\\Client\\Adapter\\Curl'
        )
    )
);
