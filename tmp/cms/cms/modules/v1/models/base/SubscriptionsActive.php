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
    { if (($__am_res = __amock_before(get_called_class(), __CLASS__, __FUNCTION__, array(), true)) !== __AM_CONTINUE__) return $__am_res; 
        return 'subscriptions_active';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    { if (($__am_res = __amock_before($this, __CLASS__, __FUNCTION__, array(), false)) !== __AM_CONTINUE__) return $__am_res; 
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
    { if (($__am_res = __amock_before($this, __CLASS__, __FUNCTION__, array(), false)) !== __AM_CONTINUE__) return $__am_res; 
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
