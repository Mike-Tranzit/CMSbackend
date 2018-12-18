<?php
namespace common\fixtures;

use yii\test\ActiveFixture;

class UsersFixture extends ActiveFixture
{
    use \common\fixtures\_actions\FixturesActions;

    public $modelClass = 'common\models\auth\Users';
    public $dataFile = '@cms/tests/_data/users_login_data.php';
}