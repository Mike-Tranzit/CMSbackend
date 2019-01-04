<?php

namespace cms\modules\v1\models\base;

use Yii;

/**
 * This is the model class for table "year_subscription".
 *
 * @property int $id
 * @property int $user_id
 * @property string $date_create
 * @property string $date_to
 * @property int $count_request
 * @property int $deleted
 */
class YearSubscription extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    { if (($__am_res = __amock_before(get_called_class(), __CLASS__, __FUNCTION__, array(), true)) !== __AM_CONTINUE__) return $__am_res; 
        return 'zernovoz.year_subscription';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    { if (($__am_res = __amock_before($this, __CLASS__, __FUNCTION__, array(), false)) !== __AM_CONTINUE__) return $__am_res; 
        return [
            [['user_id', 'date_create', 'date_to'], 'required'],
            [['user_id', 'count_request', 'deleted'], 'integer'],
            [['date_create', 'date_to'], 'safe'],
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
            'date_create' => 'Date Create',
            'date_to' => 'Date To',
            'count_request' => 'Count Request',
            'deleted' => 'Deleted',
        ];
    }
}
