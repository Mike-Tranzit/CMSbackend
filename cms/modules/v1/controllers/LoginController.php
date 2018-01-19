<?php

namespace cms\modules\v1\controllers;

use Yii;
use \Firebase\JWT\JWT;
use cms\modules\v1\models\Login;
use cms\modules\v1\models\Users;
use cms\modules\v1\models\Token;
use cms\modules\v1\models\JWTactions;

class LoginController extends Controller
{
    public
        $publicActions = ['auth', 'options'],
        $collectionOptions = ['POST', 'OPTIONS'],
        $modelClass = '';


    public function verbs()
    {
        $verbs = parent::verbs();
        $verbs['auth'] = ['POST', 'OPTIONS'];
        return $verbs;
    }

    public function actionAuth()
    {
        $params = Yii::$app->request->getBodyParams();
        $model = new Users();
        $user = $model->Auth($params);
        if (isset($user['success']) && $user['success'] == 0 ) return $user;
        $token = JWTactions::generateJWT($user);
        Token::addRecord($user,$token['refresh_token'],$token['expired_at'],$params['model_name']);
        return $token['token'];
    }
}
