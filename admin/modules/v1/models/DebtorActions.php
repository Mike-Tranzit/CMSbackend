<?php
/**
 * Created by PhpStorm.
 * User: Mihail
 * Date: 08.04.2018
 * Time: 18:10
 */

namespace admin\modules\v1\models;

use admin\modules\v1\models\Debtor;

class DebtorActions
{
    private $params;
    private $model;
    public function __construct($params)
    {
        $this->params = $params;
        $this->initModel();
    }

    public function initModel(){
        $this->model = new Debtor($this->params['data']['plate'], $this->params['id']);
    }
    public function editOne(){
        return $this->model->editOne($this->params['data']);
    }

    public function saveOne(){
        return $this->model->saveOne($this->params['data']);
    }
}