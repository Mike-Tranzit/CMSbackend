<?php
/**
 * Created by PhpStorm.
 * User: Mihail
 * Date: 11.01.2018
 * Time: 14:03
 */

namespace common\models\auth;

use \Firebase\JWT\JWT;

require_once __DIR__ . '/Token.php';
use Yii;
use common\models\auth\Token;

class JWTactions
{
    public static function generateJWT($user, $model_name)
    {
        $key = base64_decode(Yii::$app->params['token_secret_string']);
        $tokenId = Yii::$app->getSecurity()->generateRandomString(12);
        $issuedAt = time();
        $notBefore = $issuedAt + 5;
        $expire = $notBefore + 60*60*20;
        $refresh_token = Yii::$app->getSecurity()->generateRandomString(24);
        $salt = Yii::$app->getSecurity()->generateRandomString(10);
        $data = [
            'iss' => 'cms',
            'iat' => $issuedAt,
            'jti' => $tokenId,
            'nbf' => $notBefore,
            'exp' => $expire,
            'data' => [
                'id' => $user->id,
                'm_n' => $model_name,
                'salt' => $salt,
                'refresh_token' => $refresh_token
            ]
        ];
        if($user->role && isset($user->role)) $data['data']['role'] = $user->role;
        $token = JWT::encode($data, $key, 'HS256');
        $active = Token::addRecord($user, $refresh_token, $expire, $model_name, $salt);
        if (!$active) {
            return NULL;
        }
        if (isset($user->refresh_token)) Yii::$app->session->setFlash('Authorization_access', $token);
        return ['token' => $token, 'id' => $user->id];
    }

    public static function decodeJWT($token)
    {
        $key = base64_decode(Yii::$app->params['token_secret_string']);
        return JWT::decode($token, $key, array('HS256'));
    }
}