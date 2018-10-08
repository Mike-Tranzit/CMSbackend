<?php

namespace admin\modules\v1\models;

use Yii;

class Test
{
    public function __construct()
    {
        throw new \yii\web\BadRequestHttpException('Не верная дата');
    }

    /*public function transferObjest(){
        throw new \yii\web\BadRequestHttpException('Не верная дата');
    }*/
}