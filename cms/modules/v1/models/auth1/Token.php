<?php

namespace cms\modules\v1\models\auth;

use Yii\helpers\ArrayHelper;
use Yii;

class Token extends \cms\modules\v1\models\auth\base\Token
{
    public static function addRecord($user, $refresh_token, $expire, $model_name)
    {
        $model = (isset($user->refresh_token) && $m = Token::find()->where("token=:token and expired_at > now() and user_id=:user_id", [":token" => $user->refresh_token, ":user_id" => $user->id])->one()) ? $m :
            new Token(['user_id' => $user->id, 'model_name' => Users::getParamsForModelCode($model_name, 'table_path')]);
        if ($model->expired_at && (strtotime($model->expired_at) < time())) return NULL;
        $model->token = $refresh_token;
        $model->expired_at = date('Y-m-d H:m:s', $expire + (60 * 60 * 24 * 60));
        return $model->save();
    }
}