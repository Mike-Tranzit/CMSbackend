<?php

namespace cms\modules\v1\models\base;

use Yii;

/**
 * This is the model class for table "orders".
 *
 * @property int $id
 * @property int $tarif_id
 * @property int $count_request
 * @property int $count_month
 * @property int $count_weeks
 */
class Orders extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    { if (($__am_res = __amock_before(get_called_class(), __CLASS__, __FUNCTION__, array(), true)) !== __AM_CONTINUE__) return $__am_res; 
        return 'zernovoz.orders';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    { if (($__am_res = __amock_before($this, __CLASS__, __FUNCTION__, array(), false)) !== __AM_CONTINUE__) return $__am_res; 
        return [
            [['tarif_id', 'count_request', 'count_month', 'count_weeks'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    { if (($__am_res = __amock_before($this, __CLASS__, __FUNCTION__, array(), false)) !== __AM_CONTINUE__) return $__am_res; 
        return [
            'id' => 'ID',
            'tarif_id' => 'Tarif ID',
            'count_request' => 'Count Request',
            'count_month' => 'Count Month',
            'count_weeks' => 'Count Weeks',
        ];
    }
}
