<?php

$urlRule = '\app\components\UrlRule';
$pluralize = false;

return [
    'enablePrettyUrl' => true,
    'enableStrictParsing' => true,
    'showScriptName' => false,
    'rules' => [
        [
            'class' => $urlRule,
            'pluralize' => false,
            'controller' => [
                'v1/login',
            ],
            'only' => [
                'auth',
                'options'
            ],
            'patterns' => [
                'POST auth' => 'auth',
                'OPTIONS auth' => 'options'
            ]
        ],
        [
            'class' => $urlRule,
            'pluralize' => false,
            'controller' => [
                'v1/autos',
            ],
            'only' => [
                'index',
                'options',
            ],
            'patterns' => [
                'GET index' => 'index',
                'OPTIONS index' => 'options'
            ]
        ],
        [
            'class' => $urlRule,
            'pluralize' => false,
            'controller' => [
                'v1/blacklist',
            ],
            'only' => [
                'save',
                'edit',
                'options',
            ],
            'patterns' => [
                'PUT edit/<id:\d+>' => 'edit',
                'OPTIONS edit/<id:\d+>' => 'options',
                'POST save' => 'save',
                'OPTIONS save' => 'options'
            ]
        ]

    ],
];