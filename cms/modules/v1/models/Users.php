<?php

namespace cms\modules\v1\models;

use Yii;
use yii\web\IdentityInterface;
use cms\modules\v1\models\JWTactions;

class Users extends \cms\modules\v1\models\base\Users implements IdentityInterface
{

    public $password_hash;

    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id,]);
    }

    public function Auth($params)
    {
        $user = self::findByUsername($params['username']);
        if (!$user) {
           return [
                'success' => 0,
                'message' => 'No such user found'
            ];
        } else {
            if (!$this->validatePassword($params['password'])) {
                return [
                    'success' => 0,
                    'message' => 'Incorrect password'
                ];
            }
        }
        return $user;
    }

    public static function findByUsername($username)
    {
        return self::findOne(['login' => $username]);
    }

    public function getId()
    {
        return $this->getPrimaryKey();
    }

    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    public function validatePassword($password)
    {
        $this->setPassword($password);
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    public static function findIdentityByAccessToken($token,$type = NULL)
    {
        try {
            $decoded = JWTactions::decodeJWT($token, array('HS256'));

          //  return static::findByEmail($decoded->data->email);
        } catch (\Exception $e) {
            return null;
        }
    }
}
