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
    {
        return 'year_subscription';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
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
    {
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
