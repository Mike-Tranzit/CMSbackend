<?php

namespace cms\modules\v1\models\auth;

use Yii;
use yii\web\IdentityInterface;


class Users extends \yii\db\ActiveRecord implements IdentityInterface
{

    public $password_hash, $user, $auth_error = [], $params;

    public static function ModelParams()
    {
        return Params::PARAMS_LIST();
    }

    public static function getParamsForModelCode($model_key, $extra_field = NULL)
    {
        foreach (self::ModelParams() as $key => $value) {
            if ($model_key === $key) {
                return $extra_field ? $value[$extra_field] : $value;
            }
        }
        return NULL;
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public function generateToken()
    {
        if (!empty($this->auth_error)) return $this->auth_error;
        return JWTactions::generateJWT($this->user, $this->params['m_n']);
    }

    public function Auth($params)
    {
        $this->params = $params;
        $this->user = self::findByUsername($params['username'], $params['m_n']);
        if (!$this->user) {
            $this->auth_error = [
                'Status' => 'error',
                'message' => 'Такого пользователя не существует'
            ];
        } else {
            if (!$this->validatePassword()) {
                $this->auth_error = [
                    'Status' => 'error',
                    'message' => 'Не верный пароль'
                ];
            }
        }
    }

    public static function findByUsername($username, $model_key)
    {
        $params = self::getParamsForModelCode($model_key);
        if (!$params) return false;
        return $params['table_name']::find()->where([$params['login_field'] => $username])->one();
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

    public function validatePassword()
    {
        return md5($this->params['password']) == $this->user['password'];
    }

    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    public static function findIdentityByAccessToken($token, $type = NULL)
    {
        try {
            $decoded = JWTactions::decodeJWT($token);
            $id = $decoded->data->id;
            if (!isset($decoded->exp)) return NULL;
            if ($decoded->exp < time()) {
                $token = JWTactions::generateJWT($decoded->data, $decoded->data->m_n);
                if (!$token) return NULL;
                $id = $token['id'];
            }
            return self::findIdentity($id);
        } catch (\Exception $e) {
            echo $e->getMessage();
            return NULL;
        }
    }
}