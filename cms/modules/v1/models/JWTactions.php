<?php
/**
 * Created by PhpStorm.
 * User: Mihail
 * Date: 11.01.2018
 * Time: 14:03
 */

namespace cms\modules\v1\models;
use \Firebase\JWT\JWT;
use Yii;

class JWTactions
{
    public static function generateJWT($user){
        $key = base64_decode(Yii::$app->params['token_secret_string']);
        $tokenId = Yii::$app->getSecurity()->generateRandomString(12);
        $issuedAt = time();
        $notBefore = $issuedAt + 5;
        $expire = $notBefore + 1800;
        $refresh_token = Yii::$app->getSecurity()->generateRandomString(24);
        $data = [
            'iss' => 'cms.dev',
            'iat' => $issuedAt,
            'jti' => $tokenId,
            'nbf' => $notBefore,
            'exp' => $expire,
            'data' => [
                'id' => $user->id,
                'login' => $user->login,
                'refresh_token' => $refresh_token
            ]
        ];
        return ['token' => JWT::encode($data, $key, 'HS256'),'refresh_token'=>$refresh_token,'expired_at'=>$expire];
    }

    public static function decodeJWT($token){
        $key = base64_decode(Yii::$app->params['token_secret_string']);
        return JWT::decode($token, $key, array('HS256'));
    }
}