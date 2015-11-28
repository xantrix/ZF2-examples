<?php
return [
    'router' => [
        'routes' => [
            'zf2-doc-example-home'        => [
                'type'    => 'Zend\Mvc\Router\Http\Literal',
                'options' => [
                    'route'    => '/zf2-doc-example',
                    'defaults' => [
                        'controller' => 'Zf2DocExample\Controller\Index',
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],
    // Console routes
    'console' => [
        'router' => [
            'routes' => [],
        ],
    ],
];