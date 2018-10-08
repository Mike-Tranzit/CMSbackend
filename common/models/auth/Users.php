<?php

namespace common\models\auth;

require_once __DIR__ . '/Params.php';
require_once __DIR__ . '/JWTactions.php';
use common\models\auth\Params;
use common\models\auth\JWTactions;

use Yii;
use yii\web\IdentityInterface;

class Users extends \yii\db\ActiveRecord implements IdentityInterface
{

    public $password_hash, $user, $auth_error = [], $params;

    public static $id = '{{glonass.users}}';

    public static function tableName()
    {
        return self::$id;
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

    public function checkRoleAndProvider($role = 2, $provider = 2)
    {
        if ($this->user->role != $role || $this->user->isProvider != $provider) {
            $this->auth_error = [
                'Status' => 'error',
                'message' => 'В доступе отказано',
                'username' => false,
                'password' => true
            ];
        }
    }

    public function Auth($params)
    {
        $this->params = $params;
        $this->user = self::findByUsername($params['username'], $params['m_n']);
        if (!$this->user) {
            $this->auth_error = [
                'Status' => 'error',
                'message' => 'Такого пользователя не существует',
                'username' => false,
                'password' => true
            ];
        } else {
            if (!$this->validatePassword()) {
                $this->auth_error = [
                    'Status' => 'error',
                    'message' => 'Не верный пароль',
                    'username' => true,
                    'password' => false
                ];
            }
        }
    }

    public static function findByUsername($username, $model_key)
    {
        $params = Params::getParamsForModelCode($model_key);
        if (!$params) return false;
        $sql = $params['table_name']::find()->where([$params['login_field'] => $username]);
        if(isset($params['extra_sql'])) $sql->andWhere($params['extra_sql']);
        return $sql->one();
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
            $params = Params::getParamsForModelCode($decoded->data->m_n);
            self::$id = $params['table_path'];
            return self::findIdentity($id);
        } catch (\Exception $e) {
            return NULL;
        }
    }
}