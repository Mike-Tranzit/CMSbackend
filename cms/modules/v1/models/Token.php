<?php

namespace cms\modules\v1\models;

use Yii\helpers\ArrayHelper;

use Yii;

class Token extends \cms\modules\v1\models\base\Token
{
    public static function addRecord($user,$refresh_token,$expired_at, $model_name ){
        $model = new Token(['user_id'=>$user->id,'token'=>$refresh_token,'model_name'=>$model_name,'expired_at'=>date('Y-m-d H:m:s',$expired_at + (60 * 60 * 24 * 60))]);
        $model->save();
    }
}