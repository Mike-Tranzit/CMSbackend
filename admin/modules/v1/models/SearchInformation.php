<?php
/**
 * Created by PhpStorm.
 * User: Mihail
 * Date: 08.04.2018
 * Time: 18:10
 */

namespace admin\modules\v1\models;
use admin\modules\v1\models\BlackList;
use admin\modules\v1\models\Autos;
use admin\modules\v1\models\Glonass;
use admin\modules\v1\models\Objects;

class SearchInformation
{
    private $result = [];
    private $param;
    public function __construct($param)
    {
        $this->param = $param;
    }

    public function checkInBlackList(){
        $black = new BlackList($this->param);
        $this->result['black'] = $black->recordExist();
    }

    public function checkInAutosArchive(){
        $black = new Autos($this->param);
        $this->result['autos'] = $black->searchExist();
    }

    public function checkInGlonass(){
        $black = new Glonass($this->param);
        $this->result['glonass'] = $black->searchExist();
    }

    public function checkInObjects(){
        $objects = new Objects($this->param);
        $this->result['objects'] = $objects->searchExist();
    }

    public function returnResult(){
        return $this->result;
    }
}