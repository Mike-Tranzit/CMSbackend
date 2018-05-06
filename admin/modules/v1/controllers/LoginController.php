<?php

namespace admin\modules\v1\controllers;

use Yii;
require_once __DIR__ . '/../../../../common/models/auth/Users.php';
use admin\modules\v1\helpers\String;
use yii\web\HttpException;

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
        $model = new \common\models\auth\Users();
        $model->Auth($params);
        $token = $model->generateToken();
        return !isset($token['token'])? $token :['token'=>$token['token'],'Status'=>'success'];
    }
}
