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
    ],
];