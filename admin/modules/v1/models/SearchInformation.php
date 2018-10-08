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
use admin\modules\v1\models\Debtor;

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
        $this->result['load'] = true;
    }

    public function checkInDebtor(){
        $black = new Debtor($this->param);
        $this->result['debtor'] = $black->recordExist();
    }

    public function checkInAutosArchive(){
        $black = new Autos($this->param);
        $this->result['windows'] = $black->searchExist();
    }

    public function checkInGlonass(){
        $black = new Glonass($this->param);
        $this->result['glonass'] = $black->searchExist();
    }

    public function checkInObjects(){
        $objects = new Objects($this->param);
        $this->result['objects'] = $objects->searchExist();
    }

    public function checkInObjectsTerminal(){
        $objects = new Terminal($this->param);
        $this->result['terminal'] = $objects->searchExist();
        $this->result['window'] = $objects->searchExistWindow();
    }

    public function returnResult(){
        return $this->result;
    }
}