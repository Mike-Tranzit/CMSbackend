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
                'v1/b'=>'v1/blacklist',
                'v1/d'=>'v1/debtor',
                'v1/a'=>'v1/autos',
                'v1/l'=>'v1/login',
            ],
            'tokens' => [
                '{id}' => '<id:\d+>'
            ],
            'extraPatterns' => [
                'GET index' => 'index',
                'GET terminal' => 'terminal',
                'GET list' => 'list',
                'POST change' => 'change',
                'POST transfer' => 'transfer',
                'POST auth' => 'auth',
                'PUT edit/{id}' => 'edit',
                'OPTIONS edit/{id}' => 'options',
                'POST save' => 'save',
                'OPTIONS <action:\w+>' => 'options'
            ]
        ]
    ],
];