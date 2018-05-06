<?php

namespace admin\modules\v1\controllers;

use Yii;
use admin\modules\v1\models\FabricModule;
use yii\web\HttpException;

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
        return $verbs;
    }

    public function actionIndex($term)
    {
        $fabric = new FabricModule('search', $term);
        $model = $fabric->getModel();
        $model->checkInBlackList();
        $model->checkInAutosArchive();
        $model->checkInGlonass();
        $model->checkInObjects();
        return $model->returnResult();
    }
}
