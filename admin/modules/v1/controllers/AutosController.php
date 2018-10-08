<?php

namespace admin\modules\v1\controllers;

use Yii;
use admin\modules\v1\models\FabricModule;

class AutosController extends Controller
{
    public
        $publicActions = ['options'],
        $collectionOptions = ['GET', 'OPTIONS'],
        $modelClass = '';

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index']);
        return $actions;
    }

    public function verbs()
    {
        $verbs = parent::verbs();
        $verbs['index'] = ['GET', 'OPTIONS'];
        $verbs['terminal'] = ['GET', 'OPTIONS'];
        $verbs['list'] = ['GET', 'OPTIONS'];
        return $verbs;
    }

    public function actionList(){
        return \admin\modules\v1\models\Autos::listTimeslots();
    }

    public function actionTransfer(){
        $fabric = new FabricModule('transfer', Yii::$app->getRequest()->getBodyParams());
        $model = $fabric->getModel();
        return $model->Transfer();
    }

    public function actionChange(){
        $fabric = new FabricModule('priority', Yii::$app->getRequest()->getBodyParams());
        $model = $fabric->getModel();
        return $model->changePriority();
    }

    public function actionTerminal($term){
        $fabric = new FabricModule('search', $term);
        $model = $fabric->getModel();
        $model->checkInObjectsTerminal();
        return $model->returnResult();
    }

    public function actionIndex($term)
    {
        $fabric = new FabricModule('search', $term);
        $model = $fabric->getModel();
        $model->checkInBlackList();
        $model->checkInDebtor();
        $model->checkInAutosArchive();
        $model->checkInGlonass();
        $model->checkInObjects();
        return $model->returnResult();
    }
}