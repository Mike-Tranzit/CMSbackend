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
    private $provider_phone = [1=>'88002344044', 2 => '+79187626948'];
    private $model = NULL;

    public function __construct($plate)
    {
        $this->plate = \common\helpers\Plates::toBase($plate);
        $this->model = \common\models\nztmodule3\base\Glonass::find()->where('`num_auto`=:num_auto and `deleted`=0', [":num_auto" => $this->plate])->orderBy('id')->one();
    }

    public function searchExist()
    {

        return !$this->model ? [] : ['provider_phone'=>$this->provider_phone[$this->model->provider],'provider'=> $this->provider[$this->model->provider],'balance'=>(int)$this->model->balance,'plate'=> \common\helpers\Plates::fromBase($this->model->num_auto),'is_flag'=>$this->model->flag == 1? 'Аккредитован':'Не аккредитован','tel'=>strlen($this->model->tel)>0? $this->model->tel: false,'fio'=>strlen($this->model->fio)>0? $this->model->fio: false,'date_cre' =>$this->model->dates, 'is_block'=>$this->initBlockModel(),'lat'=>$this->model->lat,'lon'=>$this->model->lon,'date_last_coordinate'=>$this->model->date_last_coordinate];
    }

    public function initBlockModel(){
        $customer = new \admin\modules\v1\models\BalanceCustomer($this->model->id);
        return $customer->block_info;
    }
}