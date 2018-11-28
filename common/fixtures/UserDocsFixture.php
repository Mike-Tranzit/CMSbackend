<?php
namespace common\fixtures;

use yii\test\ActiveFixture;

class UserDocsFixture extends ActiveFixture
{
    public $modelClass = 'cms\modules\v1\models\UserDocs';
    public $depends = ['common\fixtures\UsersFixture'];
}