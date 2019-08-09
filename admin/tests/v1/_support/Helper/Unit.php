<?php
namespace admin\tests\v1\Helper;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

use yii\web\HttpException;
use admin\tests\v1\Traits\{AspectMockModels, CustomClassActions};
class Unit extends \Codeception\Module
{
    use CustomClassActions;
    use AspectMockModels;
}
