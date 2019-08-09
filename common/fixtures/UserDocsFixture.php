<?php
namespace common\fixtures;

use yii\test\ActiveFixture;

class UserDocsFixture extends ActiveFixture
{
    use \common\fixtures\_actions\FixturesActions;

    public $modelClass = 'cms\modules\v1\models\UserDocs';
    public $dataFile = '@cms/tests/_data/user_docs.php';
    public $depends = ['common\fixtures\UsersFixture'];
}