
<?php
$config = [
	'id' => 'app-api',
	'basePath' => dirname(__DIR__),
	'bootstrap' => ['log'],
    'controllerNamespace' => 'admin\controllers',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'modules' => [
        'v1' => [
            'class' => 'admin\modules\v1\Admin',
        ],
    ],
	'components' => [
		'cache' => require(__DIR__ . '/../cache.php'),
		'user' => require(__DIR__ . '/../user.php'),
		'mailer' => require(__DIR__ . '/../mailer.php'),
		'log' => require(__DIR__ . '/../log.php'),
		'db' => require(__DIR__ . '/test_db.php'),
		'urlManager' => require(__DIR__ . '/../urlManager.php'),
		'request' => require(__DIR__ . '/../request.php'),
		'response' => require(__DIR__ . '/../response.php'),
	],
    'params' => require(__DIR__ . '/../params.php')
];

return $config;