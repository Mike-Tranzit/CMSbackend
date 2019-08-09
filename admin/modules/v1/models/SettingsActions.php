<?php

namespace admin\modules\v1\models;

use Yii;

require_once __DIR__ . '/../../../../common/models/nztmodule3/base/Config.php';

use admin\modules\v1\models\HourlyLimits;

class SettingsActions
{
    private $data = [];
    private $receiverIdArray = array(
        'PerHourLimitMaxNkhp'=>2,
        'PerHourLimitMinNkhp'=>2,
        'PerHourLimitMaxNzt'=>1,
        'PerHourLimitMinNzt'=>1
    );
    public function __construct($data = [])
    {
        $this->data = $data;
    }

    private function getAll()
    {
        return \common\models\nztmodule3\base\Config::find()->select(['id', 'title','is_select','value'])->where("title is not null")->all();
    }

    public function formationJSON()
    {
        return $this->getAll();
    }

    public function change()
    {
        foreach ($this->data as $key => $value) {
            if ($model = \common\models\nztmodule3\base\Config::findOne($key)) {

                if ((int)$value != (int)$model->value && isset($this->receiverIdArray[$model->name])) {
                    $receiverId = $this->receiverIdArray[$model->name];
                    $hourLimit = new HourlyLimits($receiverId);
                    $hourLimit->saveHourLimits($value);
                }

                $model->value = (int)$value;
                $model->save(false);
            }
        }
        return $this->getAll();
    }
}
