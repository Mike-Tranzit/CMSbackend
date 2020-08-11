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
require_once __DIR__ . '/../../../../common/models/nztmodule3/base/NkhpExt.php';

use yii\web\HttpException;

class Objects
{
    private $plate;
    private $model = null;
    public $status = [
        1 => 'Зарегистрировался',
        2 => 'Ушел с терминала',
        3 => 'На территории',
        4 => 'Разгружен'
    ];


    public function __construct($plate)
    {
        $this->plate = \common\helpers\Plates::toBase($plate);
        $this->model = \common\models\nztmodule3\base\Objects::find()->where('`num_auto`=:num_auto and galina=0 and is_nkhp in(0,1) and status_m in (1,2,3,4)', [":num_auto" => $this->plate])->orderBy('id DESC')->one();
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
		switch($this->model->is_nkhp) {
			case 0: {
				return 'НЗТ';
				break
			}
			case 1: {
				return 'НКХП';
				break
			}
			case 2: {
				return 'КСК';
				break
			}
		}
    }

    public function formatoinorderFromStividor()
    {
        return ($this->model->orderFromStividor) ? $this->model->orderFromStividor : '';
    }

    public function formatoinPlace()
    {
        return ($this->model->nat == 1) ? 'НАТ' : 'Подскок';
    }

    public function searchExist()
    {
        $m = !$this->model ? [] : ['id' => $this->model->id,'license_number'=>$this->model->license_number,'fio' => $this->model->fio, 'phone' => $this->model->tel, 'status_m' => $this->status[$this->model->status_m], 'date_create' => $this->model->date_cre, 'date_registration' => $this->model->date_to_podskok . " " . $this->model->time_to_podskok, 'date_out' => $this->formatingDate(2, $this->model->date_from_podskok . " " . $this->model->time_from_podskok),
            'date_to' => $this->formatingDate(3, $this->model->date_to_nzt . " " . $this->model->time_to_nzt), 'date_from' => $this->formatingDate(3, $this->model->date_from_nzt . " " . $this->model->time_from_nzt),'date_return'=> $this->formatoinDateReturn(),'is_return' => $this->model->isReturn, 'place' => $this->formatoinPlace(), 'receiver' => $this->formatoinReceiver(),'del'=>$this->model->del,'orderFromStividor' => $this->formatoinorderFromStividor()];

        if ($this->model) {
            if ($this->model->is_nkhp == 1 && $ex = \common\models\nztmodule3\base\NkhpExt::find()->where('`pid`=:pid', [":pid"=>$this->model->id])->one()) {
                $m['trailer'] = \common\helpers\Plates::toBase($ex->trailer);
            }

            $m['glonass'] = $this->model->glonass;
            $m['priority_allow'] = 0;
            if ($this->model->status_m == 1) { // убрать
                if ((int)$this->model->status_person < 2) {
                    $m['priority_allow'] = 1;
                } else {
                    $m['priority_allow'] = 2;
                }
            }
        }



        return $m;
    }

    public static function getChangePriorityParam($priority_allow, $action)
    {
        if ($action == 'glonass') {
            return $priority_allow;
        }
        return $priority_allow == 1 ? 2: 1;
    }

    public static function getObjectById($id)
    {
        $model = \common\models\nztmodule3\base\Objects::findOne($id);
        if (!$model) {
            throw new HttpException(500, 'Запись не найдена');
        }
        return $model;
    }

    public static function markAsRemoved($data)
    {
        $model = self::getObjectById($data['id']);
        $model->del = 2;
        $model->del_date = date("Y-m-d");
        $model->del_time = date("H:i:s");
        if ($model->save()) {
            return ['id'=>$data['id']];
        } else {
            throw new HttpException(500, 'Ошибка сохранения');
        }
    }

    public static function changePriority($data)
    {
        $model = self::getObjectById($data['id']);

        if ($data['action'] == 'priority') {
            if ($data['priority_allow'] == 1) {
                $model->status_person = 2;
            } else {
                if ($model->glonass == 1) {
                    $model->status_person = 1;
                } else {
                    $model->status_person = 0;
                }
            }
        } else {
            if ($data['glonass'] == 1) {
                $model->glonass = 0;
                if ($model->status_person != 2) {
                    $model->status_person = 0;
                }
            } else {
                if ($model->status_person != 2) {
                    $model->status_person = 1;
                }
                $model->glonass = 1;
            }
        }

        if ($model->save()) {
            return ['id'=>$data['id'], 'priority_allow'=>self::getChangePriorityParam($data['priority_allow'], $data['action']), 'glonass'=>$model->glonass];
        } else {
            throw new HttpException(500, 'Ошибка сохранения');
        }
    }
}
