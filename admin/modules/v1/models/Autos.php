<?php
/**
 * Created by PhpStorm.
 * User: Mihail
 * Date: 08.04.2018
 * Time: 18:10
 */

namespace admin\modules\v1\models;

require_once __DIR__ . '/../../../../common/models/cms/base/AutosArchive.php';
require_once __DIR__ . '/../../../../common/helpers/Plates.php';

class Autos
{
    private $plate;
    private $model = NULL;

    public function __construct($plate)
    {
        $this->plate = \common\helpers\Plates::toBase($plate);
        $this->model = \common\models\cms\base\AutosArchive::find()->where('`num_auto`=:num_auto', [":num_auto" => $this->plate])->orderBy('id')->one();
    }

    public function formationPhoneDeleted()
    {
        $find_phone = strpos($this->model->delete_who, '+7');
        if ($find_phone > 0) return substr($this->model->delete_who, $find_phone);
        return '';
    }

    public function formationDeleteText()
    {
        switch ($this->model->deleted) {
            case 0:
                return 'Активен';
                break;
            case 1:
                return 'Удален';
                break;
            case 2:
                return 'Переносил';
                break;
        }
    }

    public function searchExist()
    {
        return !$this->model ? [] : ['id' => $this->model->id,'windows' => $this->model->windows, 'windows_from' => $this->model->window_from, 'date_create' => $this->model->date_cre, 'phone' => $this->model->phone, 'arrived'=> (int)$this->model->arrived, 'deleted' => $this->formationDeleteText(), 'delete_who' => $this->formationPhoneDeleted(), 'delete_date' => $this->model->delete_date? $this->model->delete_date: ''];
    }
}