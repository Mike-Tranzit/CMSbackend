<?php
/**
 * Created by PhpStorm.
 * User: Mihail
 * Date: 11.01.2018
 * Time: 14:03
 */

namespace cms\modules\v1\models\auth;
use \Firebase\JWT\JWT;
use Yii;
use cms\modules\v1\models\auth\Token;

class JWTactions
{
    public static function generateJWT($user,$model_name){
        $key = base64_decode(Yii::$app->params['token_secret_string']);
        $tokenId = Yii::$app->getSecurity()->generateRandomString(12);
        $issuedAt = time();
        $notBefore = $issuedAt + 5;
        $expire = $notBefore + 2;
        $refresh_token = Yii::$app->getSecurity()->generateRandomString(24);
        $data = [
            'iss' => 'cms.info',
            'iat' => $issuedAt,
            'jti' => $tokenId,
            'nbf' => $notBefore,
            'exp' => $expire,
            'data' => [
                'id' => $user->id,
                'm_n' => $model_name,
                'refresh_token' => $refresh_token
            ]
        ];
        $token = JWT::encode($data, $key, 'HS256');
        $active = Token::addRecord($user,$refresh_token,$expire,$model_name);
        if(!$active) return NULL;
        if(isset($user->refresh_token)) Yii::$app->session->setFlash('Authorization_access',$token);
        return ['token'=>$token,'id'=> $user->id];
    }

    public static function decodeJWT($token){
        $key = base64_decode(Yii::$app->params['token_secret_string']);
        return JWT::decode($token, $key, array('HS256'));
    }
}