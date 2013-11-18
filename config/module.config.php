<?php

return array(
    'view_manager' => array(
        'template_map' => array(
            'enrise/workbench/index' => __DIR__ . '/../view/workbench/index.phtml',
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
        )
    ),

    'controllers' => array(
        'invokables' => array(
            'Enrise\Apigility\Workbench\Workbench' => 'Enrise\Apigility\Workbench\WorkbenchController',
        ),
    ),

    'router' => array(
        'routes' => array(
            'enrise-apigility-workbench' => array(
                'type'  => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/workbench',
                    'defaults' => array(
                        'controller' => 'Enrise\Apigility\Workbench\Workbench',
                        'action'     => 'index',
                    ),
                ),
                'may_terminate' => true,
            )
        )
    )
);
