<?php

namespace cms\modules\v1\models\base;

use Yii;

/**
 * This is the model class for table "subscriptions_active".
 *
 * @property int $id
 * @property int $user_id
 * @property int $requests_left
 * @property int $permanent
 * @property int $plan_id
 * @property string $add_date
 * @property string $burnout_date
 */
class SubscriptionsActive extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'subscriptions_active';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'requests_left'], 'required'],
            [['user_id', 'requests_left', 'permanent', 'plan_id'], 'integer'],
            [['add_date', 'burnout_date'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'requests_left' => 'Requests Left',
            'permanent' => 'Permanent',
            'plan_id' => 'Plan ID',
            'add_date' => 'Add Date',
            'burnout_date' => 'Burnout Date',
        ];
    }
}
