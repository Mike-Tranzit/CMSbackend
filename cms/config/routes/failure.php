<?
$urlRule = 'app\components\UrlRule';
return [
    'class' => 'yii\rest\UrlRule',
    'pluralize' => false,
    'controller' => [
        'v1/f' => 'v1/failures',
    ],
    'extraPatterns' => [
        'GET types' => 'gettypes',
        'GET list' => 'getlist',
        'OPTIONS <action:\w+>' => 'options',
        'POST solved' => 'solved',
    ]
];
