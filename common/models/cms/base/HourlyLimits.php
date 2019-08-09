<?php

namespace common\models\cms\base;

use Yii;

/**
 * This is the model class for table "hourly_limits".
 *
 * @property int $receiver
 * @property int $hourly_limit_min
 * @property int $hourly_limit_max
 */
class HourlyLimits extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cms.hourly_limits';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['receiver', 'hourly_limit_min', 'hourly_limit_max'], 'required'],
            [['receiver', 'hourly_limit_min', 'hourly_limit_max'], 'integer'],
            [['receiver'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'receiver' => 'Receiver',
            'hourly_limit_min' => 'Hourly Limit Min',
            'hourly_limit_max' => 'Hourly Limit Max',
        ];
    }
}
