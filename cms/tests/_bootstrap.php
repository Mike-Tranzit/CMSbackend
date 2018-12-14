<?php
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'test');
defined('YII_APP_BASE_PATH') or define('YII_APP_BASE_PATH', __DIR__.'/../../');


require_once YII_APP_BASE_PATH . '/vendor/autoload.php';

// require_once YII_APP_BASE_PATH . '/vendor/autoload.php';
require_once(YII_APP_BASE_PATH . '/vendor/yiisoft/yii2/Yii.php');
require_once YII_APP_BASE_PATH . '/common/config/bootstrap.php';
require_once __DIR__ . '/../config/bootstrap.php';

$kernel = AspectMock\Kernel::getInstance();
$kernel->init([
    'debug' => true,
    'cacheDir'  => YII_APP_BASE_PATH. 'tmp/cms',
    'includePaths' => [
        YII_APP_BASE_PATH.'/cms',
    ],
    'excludePaths' => [YII_APP_BASE_PATH.'/cms/tests']
]);

//$kernel->loadFile(YII_APP_BASE_PATH . '/vendor/yiisoft/yii2/Yii.php');
