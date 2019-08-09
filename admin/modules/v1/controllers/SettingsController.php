<?php

namespace admin\modules\v1\controllers;

use Yii;
use admin\modules\v1\models\FabricModule;
use yii\web\HttpException;

class SettingsController extends Controller
{
    public
        $publicActions = ['options'],
        $collectionOptions = ['POST', 'OPTIONS'],
        $modelClass = '';

    public function actions()
    {
        $actions = parent::actions();
        return $actions;
    }

    public function verbs()
    {
        $verbs = parent::verbs();
        $verbs['savelist'] = ['POST', 'OPTIONS'];
        return $verbs;
    }

    public function actionList()
    {
        $fabric = new FabricModule('settings');
        $model = $fabric->getModel();
        return $model->formationJSON();
    }

    public function actionChange() {
        $fabric = new FabricModule('settings', Yii::$app->getRequest()->getBodyParams());
        $model = $fabric->getModel();
        return $model->change();
    }
}
