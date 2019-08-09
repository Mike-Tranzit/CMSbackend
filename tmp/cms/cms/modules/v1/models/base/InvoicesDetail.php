<?php

namespace cms\modules\v1\models\base;

use Yii;

/**
 * This is the model class for table "invoices_detail".
 *
 * @property int $id
 * @property string $date_create
 * @property int $user_id
 * @property string $date_old
 * @property string $date_new
 * @property int $sub_active_old
 * @property int $sub_active_new
 * @property int $invId
 */
class InvoicesDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    { if (($__am_res = __amock_before(get_called_class(), __CLASS__, __FUNCTION__, array(), true)) !== __AM_CONTINUE__) return $__am_res; 
        return 'zernovoz.invoices_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    { if (($__am_res = __amock_before($this, __CLASS__, __FUNCTION__, array(), false)) !== __AM_CONTINUE__) return $__am_res; 
        return [
            [['date_create', 'date_old', 'date_new'], 'safe'],
            [['user_id', 'sub_active_old', 'sub_active_new', 'invId'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    { if (($__am_res = __amock_before($this, __CLASS__, __FUNCTION__, array(), false)) !== __AM_CONTINUE__) return $__am_res; 
        return [
            'id' => 'ID',
            'date_create' => 'Date Create',
            'user_id' => 'User ID',
            'date_old' => 'Date Old',
            'date_new' => 'Date New',
            'sub_active_old' => 'Sub Active Old',
            'sub_active_new' => 'Sub Active New',
            'invId' => 'Inv ID',
        ];
    }
}
