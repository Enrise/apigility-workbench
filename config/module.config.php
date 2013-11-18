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
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
        )
    ),

    'router' => array(
        'routes' => array(
            'enrise-apigility-workbench' => array(
                'type'  => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/workbench',
                    'defaults' => array(
                        'controller' => 'Enrise\Apigility\Workbench\Controller\Workbench',
                        'action'     => 'index',
                    ),
                ),
                'may_terminate' => true,
            )
        )
    ),
    'apigility-workbench' => array(
        'httpclient' => array(
            ''
        )
    )
);
