<?php
/**
 * Created by PhpStorm.
 * User: Mihail
 * Date: 08.04.2018
 * Time: 18:10
 */

namespace admin\modules\v1\models;

require_once __DIR__ . '/../../../../common/models/nztmodule3/base/Objects.php';
require_once __DIR__ . '/../../../../common/models/nztmodule3/base/NkhpExt.php';
require_once __DIR__ . '/../../../../common/helpers/Plates.php';
require_once __DIR__ . '/../../../../common/models/cms/base/Autos.php';

class Terminal
{
    private $plate;
    private $model = NULL;

    public function __construct($plate)
    {
        $this->plate = \common\helpers\Plates::toBase($plate);
        $this->model = \common\models\nztmodule3\base\Objects::find()->where('`num_auto`=:num_auto and galina=0 and del in(0,2) and is_nkhp in(0,1) and status_m in (-2,0,1,2)', [":num_auto" => $this->plate])->orderBy('id DESC')->one();
    }

    public function formatingDate($status, $date)
    {
        return ($this->model->status_m >= $status) ? $date : '';
    }

    public function formatoinDateReturn()
    {
        return ($this->model->dateReturn) ? $this->model->dateReturn : '';
    }

    public function formatoinReceiver()
    {
        return ($this->model->is_nkhp == 1) ? 'НКХП' : 'НЗТ';
    }

    public function formatoinPlace()
    {
        return ($this->model->nat == 1) ? 'НАТ' : 'Подскок';
    }

    public function searchExistWindow(){
        $model = \common\models\cms\base\Autos::find()->where('`num_auto`=:num_auto', [":num_auto" => $this->plate])->orderBy('id')->one();
        return !$model ? [] : ['id' => $model->id,'windows' => $model->windows, 'window_from' =>$model->window_from, 'window_to' => $model->window_to, 'date_cre' => $model->date_cre, 'phone' => $model->phone, 'arrived'=> (int)$model->arrived, 'deleted' => '', 'delete_who' => '', 'delete_date' =>''];
    }

    public function searchExist(){
        if(!$this->model) return ['plate'=>$this->plate];
        $result = ['id'=>$this->model->id,'del'=>$this->model->del,'plate'=>$this->plate,'date_create' => $this->model->date_cre,'orderFromStividor'=>''];
        if($this->model->status_m == -2){
            $result = array_merge($result,['status_m'=>'Заехал, не регистрировался','date_to'=>'','date_from'=>'','date_out'=>'','date_registration'=>'','phone'=>'']);
            return $result;
        }
        if($this->model->status_m == 0){
            $result = array_merge($result,['status_m'=>'Заехал, не регистрировался','date_to'=>'','date_from'=>'','date_out'=>'','date_registration'=>'','phone'=>'']);
            return $result;
        }

        if(in_array($this->model->status_m,array(1,2))){

            $result = array_merge($result,['status_m'=>'Зарегистрировался', 'fio' => $this->model->fio, 'phone' => '+7' . $this->model->tel, 'date_registration' => $this->model->date_to_podskok . " " . $this->model->time_to_podskok, 'place' => $this->formatoinPlace(), 'date_return'=> $this->formatoinDateReturn(),'is_return' => $this->model->isReturn, 'receiver' => $this->formatoinReceiver(),'date_out'=>'','date_to'=>'','date_from'=>'']);

            if($this->model->is_nkhp == 1 && $ex = \common\models\nztmodule3\base\NkhpExt::find()->where('`pid`=:pid',[":pid"=>$this->model->id])->one()) {
                $result['trailer'] = \common\helpers\Plates::toBase($ex->trailer);
            }
            if($this->model->status_m == 2){
                $result['date_out'] = $this->formatingDate(2, $this->model->date_from_podskok . " " . $this->model->time_from_podskok);
            }

            return $result;
        }
    }
}