<?php
/**
 * Created by PhpStorm.
 * User: Mihail
 * Date: 08.04.2018
 * Time: 18:10
 */

namespace admin\modules\v1\models;

use admin\modules\v1\models\Objects;

class ObjectsActions
{
    private $params;
    private $model;
    public function __construct($params)
    {
        $this->params = $params;
    }

    public function changePriority(){
        return Objects::changePriority($this->params);
    }

}