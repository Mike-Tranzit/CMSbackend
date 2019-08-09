<?php
/**
 * Created by PhpStorm.
 * User: Mihail
 * Date: 08.04.2018
 * Time: 18:10
 */

namespace admin\modules\v1\models;

require_once __DIR__ . '/../../../../common/models/nztmodule3/base/Debtor.php';
require_once __DIR__ . '/../../../../common/helpers/Plates.php';
require_once __DIR__ . '/../../../../common/helpers/StringHelp.php';
use yii\web\HttpException;
use Yii;
class Debtor
{
    private $plate;
    private $model = NULL;

    public function __construct($plate, $id = 0)
    {
        $this->plate = \common\helpers\Plates::toBase($plate);
        if((int)$id > 0) $this->model = $this->findByPk($id);
        else $this->model = \common\models\nztmodule3\base\Debtor::find()->where('`plate`=:plate and status = 0', [":plate" => $this->plate])->orderBy('id')->one();
    }

    public function findByPk($id){
        return \common\models\nztmodule3\base\Debtor::findOne($id);
    }

    public function recordExist()
    {
        return !$this->model ? [] : ['id' => $this->model->id, 'status' => (boolean)$this->model->status, 'plate' => $this->model->plate,'sum' => $this->model->sum, 'date_create' => $this->model->date_create, 'description'=>$this->model->description];
    }

    /*      Edit        */
    public function editOne($data){
        if(!$this->model) throw new HttpException(400,'Запись не найдена');
        $this->model->description = \common\helpers\StringHelp::filterJSON($data['description']);
        $this->model->status = (int)$data['status'];
        if(!$this->model->save()) throw new HttpException(500,'Ошибка редактирования');
        return $this->model->status == 1? [] : $this->recordExist();
    }

    /*      Save        */
    public function saveOne($data){
        $this->model = new \common\models\nztmodule3\base\Debtor();
        $this->model->plate = trim($this->plate);
        $this->model->paid_sum = 0;
        $this->model->sum = $data['sum'];
        $this->model->description = \common\helpers\StringHelp::filterJSON($data['description']);
        $this->model->date_last_pay = NULL;
        $this->model->status = 0;
        $this->model->date_create = date("Y-m-d H:i:s");
        if(!$this->model->save()) throw new HttpException(500,'Ошибка сохранения');
        return $this->recordExist();
    }
    /*                  */
}
