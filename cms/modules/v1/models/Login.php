<?php

namespace cms\modules\v1\models;

use Yii;
use cms\modules\v1\models\Token;
use cms\modules\v1\models\User;
use yii\base\Model;

class Login extends Model
{
    public $username;
    public $password;
    private $_user;

    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            ['password', 'validatePassword'],
        ];
    }

    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }

    public function auth()
    {
        if ($this->validate()) {
            $token = new Token();
            $token->user_id = $this->getUser()->id;
            $token->generateToken(time() + 3600 * 24); // Предлагаю время жизни токена перенести в конфиг
            return $token->save() ? $token : null;
        } else {
            return null;
        }
    }

    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }
}
