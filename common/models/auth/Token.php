<?php

namespace common\models\auth;

require_once __DIR__ . '/base/Token.php';
require_once __DIR__ . '/Params.php';
use common\models\auth\Params;
use Yii\helpers\ArrayHelper;
use Yii;

class Token extends \common\models\auth\base\Token
{
    public static function addRecord($user, $refresh_token, $expire, $model_name, $salt)
    {
        $params = Params::getParamsForModelCode($model_name);
        if(isset($user->refresh_token)){
            if(!$model = Token::find()->where("token=:token and expired_at > now() and user_id=:user_id", [":token" => $user->refresh_token, ":user_id" => $user->id])->one()) {
                return NULL;
            }
        }else{
            $model = new Token(['user_id' => $user->id, 'model_name' => $params['table_path']]);
        }
        if ($model->expired_at && (strtotime($model->expired_at) < time())) {
            return self::clearTokens($user->refresh_token);
        }
        if($model->salt && $model->salt !== $user->salt) return self::clearTokens($user->refresh_token);
        $model->token = $refresh_token;
        $model->salt = $salt;
        $model->expired_at = date('Y-m-d H:m:s', $expire + (60 * 60 * 24 * 60));
        return $model->save();
    }


    public static function clearTokens($token){
        Token::deleteAll("token=:token",[':token' => $token]);
        return NULL;
    }
}