<?php
/**
 * Created by PhpStorm.
 * User: Mihail
 * Date: 08.04.2018
 * Time: 18:03
 */

namespace admin\modules\v1\models;
use Yii;

class FabricModule
{
    private $model = NULL;
    private $params = [];
    function __construct($param, $params = [])
    {
        $this->params = $params;
        switch ($param) {
            case 'search': $this->setModule('\admin\modules\v1\models\SearchInformation'); break;
            case 'blacklist': $this->setModule('\admin\modules\v1\models\BlackListActions'); break;
            case 'debtor': $this->setModule('\admin\modules\v1\models\DebtorActions'); break;
            case 'priority': $this->setModule('\admin\modules\v1\models\ObjectsActions'); break;
            case 'transfer': $this->setModule('\admin\modules\v1\models\AutosActions'); break;
        }
    }

    public function getModel()
    {
        return $this->model;
    }

    private function setModule($name)
    {
        $this->model = new $name($this->params);
    }
}