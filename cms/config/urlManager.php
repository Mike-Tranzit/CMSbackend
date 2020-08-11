<?php

$urlRule = 'app\components\UrlRule';
$pluralize = false;

return [
    'enablePrettyUrl' => true,
    'enableStrictParsing' => true,
    'showScriptName' => false,
    'rules' => [
        [
            'class' => 'yii\rest\UrlRule',
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
            'class' => 'yii\rest\UrlRule',
            'pluralize' => false,
            'controller' => [
                'v1/zernovozam',
            ],
            'only' => [
                'searchbylogin',
                'saveprofile',
                'invoicesconfirm',
                'options',
                'userdocslist'
            ],
            'patterns' => [
                'GET searchbylogin' => 'searchbylogin',
                'OPTIONS searchbylogin' => 'options',
                'PUT saveprofile' => 'saveprofile',
                'OPTIONS saveprofile' => 'options',
                'PUT invoicesconfirm' => 'invoicesconfirm',
                'OPTIONS invoicesconfirm' => 'options',
                'GET userdocslist' => 'userdocslist',
                'OPTIONS userdocslist' => 'options'
            ]
        ],
        require(__DIR__ . '/routes/failure.php')
    ],
];
