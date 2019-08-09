<?php

namespace admin\modules\v1\models;
use Yii;
require_once __DIR__ . '/../../../../common/models/cms/base/HourlyLimits.php';

class HourlyLimits {
    private $receiver;

    public function __construct($receiver) {
        $this->receiver = $receiver;
    }

    public function saveHourLimits($value) {
        if ($model = \common\models\cms\base\HourlyLimits::find()->where("receiver=:receiver", [":receiver" => $this->receiver])->one()) {
            $model->hourly_limit_max = $value;
            $model->hourly_limit_min = $value-1;
            $model->save();
        }
    }
}