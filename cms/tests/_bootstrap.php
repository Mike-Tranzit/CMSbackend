<?php

use AspectMock\Kernel;


defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'test');
defined('YII_APP_BASE_PATH') or define('YII_APP_BASE_PATH', __DIR__.'/../../');



require_once YII_APP_BASE_PATH . '/vendor/autoload.php';

$kernel = Kernel::getInstance();
$kernel->init([
    'debug' => true,
    'cacheDir' => YII_APP_BASE_PATH. 'tmp/cms',
    'includePaths' => [
        __DIR__. '/../../cms'
    ]
]);

$kernel->loadFile(YII_APP_BASE_PATH . '/vendor/yiisoft/yii2/Yii.php');
$kernel->loadFile(YII_APP_BASE_PATH . '/vendor/yiisoft/yii2/base/UnknownClassException.php');
$kernel->loadFile(YII_APP_BASE_PATH . '/vendor/yiisoft/yii2/base/ErrorException.php');

\Go\ParserReflection\ReflectionEngine::init(
    new class implements \Go\ParserReflection\LocatorInterface {
        public function locateClass($className) {
            return (new ReflectionClass($className))->getFileName();
        }
    }
);

require_once __DIR__ . '/../config/bootstrap.php';
require_once YII_APP_BASE_PATH . '/common/config/bootstrap.php';