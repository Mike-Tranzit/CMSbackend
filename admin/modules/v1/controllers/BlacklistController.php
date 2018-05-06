<?php

namespace admin\modules\v1\controllers;

use Yii;
use admin\modules\v1\models\FabricModule;
use yii\web\HttpException;

class BlacklistController extends Controller
{
    public
        $publicActions = ['options'],
        $collectionOptions = ['PUT', 'POST', 'OPTIONS'],
        $modelClass = '';

    public function actions()
    {
        $actions = parent::actions();
        return $actions;
    }

    public function verbs()
    {
        $verbs = parent::verbs();
        $verbs['edit'] = ['PUT', 'OPTIONS'];
        $verbs['save'] = ['POST', 'OPTIONS'];
        return $verbs;
    }

    public function actionSave()
    {
        $fabric = new FabricModule('blacklist', ['id' => 0, 'data' => Yii::$app->getRequest()->getBodyParams()]);
        $model = $fabric->getModel();
        return $model->saveOne();
    }

    public function actionEdit($id)
    {
        $fabric = new FabricModule('blacklist', ['id' => $id, 'data' => Yii::$app->getRequest()->getBodyParams()]);
        $model = $fabric->getModel();
        return $model->editOne();
    }
}
