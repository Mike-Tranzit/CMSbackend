<?php
/**
 * Created by PhpStorm.
 * User: Mihail
 * Date: 08.04.2018
 * Time: 18:10
 */

namespace admin\modules\v1\models;

require_once __DIR__ . '/../../../../common/models/nztmodule3/base/WhiteAndBlackList.php';
require_once __DIR__ . '/../../../../common/helpers/Plates.php';
require_once __DIR__ . '/../../../../common/helpers/String.php';
use yii\web\HttpException;
use Yii;
class BlackList
{
    private $plate;
    private $model = NULL;
    public function __construct($plate, $id = 0)
    {
        $this->plate = \common\helpers\Plates::toBase($plate);
        if($id > 0) $this->model = $this->findByPk($id);
        else $this->model = \common\models\nztmodule3\base\WhiteAndBlackList::find()->where('`num_auto`=:num_auto and wh=2 and `time_out`>=date(now())', [":num_auto"=>$this->plate])->orderBy('id')->one();
    }

    public function findByPk($id){
        return \common\models\nztmodule3\base\WhiteAndBlackList::findOne($id);
    }

    public function recordExist(){
        return !$this->model ? [] : ['id'=> $this->model->id, 'textp' => $this->model->textp, 'texts' => $this->model->texts, 'plate'=> $this->model->num_auto, 'status'=>$this->formationStatusText(), 'time_out'=> $this->formationDateOut()];
    }

    public function formationDateOut(){
        return $this->model->non_time == 1? 'бессрочно' : 'до '.date('d.m.y',strtotime($this->model->time_out));
    }

    public function formationStatusText(){
        if($this->model->power==1 and $this->model->action==0) return 1;
        if($this->model->power==1 and $this->model->action==1) return 2;
        if($this->model->power==0 ) return 3;
    }

    /*      Edit        */
    public function editOne($data){
        if(!$this->model) throw new HttpException(400,'record not found');
        $this->loadParams($data);
        if(!$this->model->save()) throw new HttpException(500,'error edit');
        return $this->recordExist();
    }

    public function loadParams($data){
        $this->model->texts = \common\helpers\String::filterJSON($data['texts']);
        $this->model->textp = \common\helpers\String::filterJSON($data['textp']);
        switch ($data['status']) {
            case 1: {
                $this->model->power = 1;
                $this->model->action = 0;
                break;
            }
            case 2: {
                $this->model->power = 1;
                $this->model->action = 1;
                break;
            }
            case 3: {
                $this->model->power = 0;
                break;
            }
        }
    }
    /*                  */
    /*      Save        */
    public function saveOne($data){
        $this->model = new \common\models\nztmodule3\base\WhiteAndBlackList();
        $this->loadParams($data);
        $this->model->num_auto = trim($this->plate);
        $this->model->non_time = ($data['time_out'] == 0) ? 1 : 0;
        $this->model->who = Yii::$app->user->id;
        $this->model->wh = 2;
        $this->model->time_add = new \yii\db\Expression('NOW()');
        $this->model->time_out = ((int)$data['time_out'] > 0)? new \yii\db\Expression("ADDDATE(NOW(),interval '" . (int)$data['time_out'] . "' DAY)"): '2283-03-02';
        if(!$this->model->save()) throw new HttpException(500,'error edit');
        return $this->recordExist();
    }
    /*                  */
}