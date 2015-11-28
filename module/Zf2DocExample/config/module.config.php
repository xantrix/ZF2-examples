<?php
return [
    'authentication' => [
    ],
    'service_manager'   => [
        'invokables' => [

        ],
        'factories' => [
        ],
    ],
    'controllers'           => [
        'invokables' => [
            'Zf2DocExample\Controller\Index' => 'Zf2DocExample\Controller\IndexController'
        ],
    ],
    'view_manager'          => [
        'template_path_stack'      => [
            __DIR__ . '/../view',
        ],
    ],
];