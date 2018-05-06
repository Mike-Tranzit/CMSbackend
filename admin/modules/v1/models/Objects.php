<?php
/**
 * Created by PhpStorm.
 * User: Mihail
 * Date: 08.04.2018
 * Time: 18:10
 */

namespace admin\modules\v1\models;

require_once __DIR__ . '/../../../../common/models/nztmodule3/base/Objects.php';
require_once __DIR__ . '/../../../../common/helpers/Plates.php';

class Objects
{
    private $plate;
    private $model = NULL;
    public $status = [
        1 => 'Зарегистрировался',
        2 => 'Ушел с терминала',
        3 => 'На территории',
        4 => 'Выгрузился'
    ];

    /*

    fio: string;
    phone: number;
    status_m: string;
    date_create: string;
    date_registration?: string;
    date_out?: string;
    date_to?: string;
    date_from?: string;
    is_return: string;
    date_return?: string;
     *  place: string;
    receiver: string;
     * */

    public function __construct($plate)
    {
        $this->plate = \common\helpers\Plates::toBase($plate);
        $this->model = \common\models\nztmodule3\base\Objects::find()->where('`num_auto`=:num_auto and galina=0 and del in(0,2) and is_nkhp in(0,1) and status_m in (1,2,3,4)', [":num_auto" => $this->plate])->orderBy('id')->limit(2)->one();
    }

    public function formatingDate($status, $date)
    {
        return ($this->model->status_m >= $status) ? $date : '';
    }

    public function formatoinReturn()
    {
        return ($this->model->isReturn > 0) ? 'Возврат' : '';
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
        return ($this->model->nat == 1) ? 'Нат' : 'Подскок';
    }

    public function searchExist()
    {
        return !$this->model ? [] : ['id' => $this->model->id, 'fio' => $this->model->fio, 'phone' => '+7' . $this->model->tel, 'status_m' => $this->status[$this->model->status_m], 'date_create' => $this->model->date_cre, 'date_registration' => $this->model->date_to_podskok . " " . $this->model->time_to_podskok, 'date_out' => $this->formatingDate(2, $this->model->date_from_podskok . " " . $this->model->time_from_podskok),
            'date_to' => $this->formatingDate(3, $this->model->date_to_nzt . " " . $this->model->time_to_nzt), 'date_from' => $this->formatingDate(3, $this->model->date_from_nzt . " " . $this->model->time_from_nzt),'date_return'=> $this->formatoinDateReturn(),'is_return' => $this->formatoinReturn(), 'place' => $this->formatoinPlace(), 'receiver' => $this->formatoinReceiver()];
    }
}