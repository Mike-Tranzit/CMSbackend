<?php

namespace admin\modules\v1\helpers;

use Yii;
use yii\helpers\Url;

class Response
{
    public static function Response201($id)
    {
        $response = Yii::$app->getResponse();
        $response->setStatusCode(201);
        $response->getHeaders()->set('Location', Url::toRoute(['view', 'id' => $id], true));
        return $response;
    }

    public static function checkModel($error_text = 'Objects not found.'){
        if(!empty($model)) {
            return $model;
        } else {
            throw new NotFoundHttpException($error_text);
        }
    }

}