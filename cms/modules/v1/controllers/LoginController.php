<?php

namespace cms\modules\v1\controllers;

use Yii;
require_once __DIR__ . '/../../../../common/models/auth/Users.php';
use cms\modules\v1\helpers\StringHelp;

class LoginController extends Controller
{
    public
        $publicActions = ['auth','options'],
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
        $params['username'] = "+" . StringHelp::clearPhoneNumber($params['username']);
        $model = new \common\models\auth\Users();
        $model->Auth($params);
        if(!empty($model->auth_error)) return $model->auth_error;
        $model->checkRoleAndProvider();
        $token = $model->generateToken();
        return !isset($token['token'])? $token :['token'=>$token['token'],'Status'=>'success'];
    }
}