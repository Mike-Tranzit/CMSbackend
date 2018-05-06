<?php
/**
 * Created by PhpStorm.
 * User: Mihail
 * Date: 08.04.2018
 * Time: 18:10
 */

namespace admin\modules\v1\models;

require_once __DIR__ . '/../../../../common/models/nztmodule3/base/Glonass.php';
require_once __DIR__ . '/../../../../common/helpers/Plates.php';

class Glonass
{
    private $plate;
    private $provider = [1=>'Южные технологии', 2 => 'Порт-Транзит'];
    private $model = NULL;

    public function __construct($plate)
    {
        $this->plate = \common\helpers\Plates::toBase($plate);
        $this->model = \common\models\nztmodule3\base\Glonass::find()->where('`num_auto`=:num_auto and `deleted`=0', [":num_auto" => $this->plate])->orderBy('id')->one();
    }

    public function searchExist()
    {
        return !$this->model ? [] : ['id' => $this->model->id,'provider'=> $this->provider[$this->model->provider],'balance'=>(int)$this->model->balance,'plate'=> $this->model->num_auto,'is_block'=>$this->initBlockModel(),'lat'=>$this->model->lat,'lon'=>$this->model->lon,'date_last_coordinate'=>$this->model->date_last_coordinate];
    }

    public function initBlockModel(){
        $customer = new \admin\modules\v1\models\BalanceCustomer($this->model->id);
        return $customer->block_info;
    }
}