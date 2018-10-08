<?php

namespace admin\modules\v1\models;
use Yii;
require_once __DIR__ . '/../../../../common/models/cms/base/AutosArchive.php';
require_once __DIR__ . '/../../../../common/models/cms/base/Autos.php';
require_once __DIR__ . '/../../../../common/helpers/Forservice.php';

class AutosActions
{

    private $params;
    private $date;
    public $plate;
    private $model;
    public function __construct($params)
    {
        $this->params = $params;
        $this->date = $this->params['window_date']." ".$this->params['window_time'].":00";
        $this->checkValidDate();
    }

    public function attributesModel($model,$modelNew){
        foreach($model as $k=>$v){
            if($k!='id' && $modelNew->hasAttribute($k)) $modelNew->$k = $v;
        }
        return $modelNew;
    }

    public function sendSms(){
        \common\helpers\Forservice::sms( "Окно авто ".$this->model->num_auto." перенесено на ".date("H:i d-m-y",strtotime($this->model->windows)), $this->model->phone );
        return true;
    }

    public function createWindow(){

        if($this->model = \common\models\cms\base\Autos::findOne((int)$this->params['id'])){

            $this->plate = $this->model->num_auto;

            if($this->date == $this->model->windows) return true;

            $model = new \common\models\cms\base\Autos;

            $model = $this->attributesModel($this->model,$model);

            $model->windows = $this->date;

            $model->arrived = 0;

            $model->window_from = date("Y-m-d H:i:s",strtotime("{$model->windows} -60 minutes"));

            $model->window_to = date("Y-m-d H:i:s",strtotime("{$model->windows} +120 minutes"));

            if(!$model->save()) throw new \yii\web\HttpException(500, 'Ошибка создания таймслота');

            $archive = new \common\models\cms\base\AutosArchive;

            $archive = $this->attributesModel($model,$archive);

            $archive->id = $model->id;

            $archive->arrived = 0;

            $archive->window_from =  $model->window_from;

            $archive->window_to = $model->window_to;

            if(!$archive->save()) throw new \yii\web\HttpException(500, 'Ошибка создания таймслота');

        }else throw new \yii\web\HttpException(500, 'Ошибка. Запись не найдена');

        return true;
    }

    public function updateAndDeleteWindow(){
        $autosArchive = \common\models\cms\base\AutosArchive::findOne($this->params['id']);
        $autosArchive->deleted = 2;
        $autosArchive->delete_date = new \yii\db\Expression('NOW()');
        $autosArchive->delete_who = 'admin mobile ('.Yii::$app->user->id.')';
        if(!$autosArchive->update()) throw new \yii\web\HttpException(500, 'Ошибка удаления таймслота');

        if(!\common\models\cms\base\Autos::findOne($this->params['id'])->delete()) throw new \yii\web\HttpException(500, 'Ошибка удаления таймслота');
    }

    public function checkValidDate(){
        $year = date("Y",strtotime($this->date));
        if($year === "1970") { throw new \yii\web\BadRequestHttpException('Ошибка. Не верная дата'); }
    }

    public function Transfer(){


        $transaction = Yii::$app->db->beginTransaction();;
        try {

            $saved = $this->createWindow();

            if($saved) $this->updateAndDeleteWindow();

            if((boolean) $this->params['sms']) $saved = $this->sendSms() && $saved;



        } catch (\Exception $e) {
            $saved = false;
            throw $e;
        }

        if($saved){
            $transaction->commit();
            $black = new \admin\modules\v1\models\Autos($this->plate);
            return $black->searchExist();
        }else $transaction->rollBack();

    }

}