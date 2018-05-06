<?php

namespace common\models\cms\base;

use Yii;

/**
 * This is the model class for table "autos_archive".
 *
 * @property int $id
 * @property string $num_auto
 * @property int $prov
 * @property int $trader
 * @property string $windows
 * @property string $window_from
 * @property string $window_to
 * @property int $confirm
 * @property string $date_cre
 * @property int $culture
 * @property int $receiver
 * @property string $phone
 * @property int $deleted
 * @property string $arrived
 * @property string $delete_date
 * @property string $delete_who
 * @property int $is_dirty
 */
class AutosArchive extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cms.autos_archive';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'prov', 'trader', 'confirm', 'culture', 'receiver', 'deleted', 'arrived', 'is_dirty'], 'integer'],
            [['windows', 'window_from', 'window_to', 'date_cre', 'delete_date'], 'safe'],
            [['phone'], 'string'],
            [['num_auto'], 'string', 'max' => 25],
            [['delete_who'], 'string', 'max' => 50],
            [['id'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'num_auto' => 'Num Auto',
            'prov' => 'Prov',
            'trader' => 'Trader',
            'windows' => 'Windows',
            'window_from' => 'Window From',
            'window_to' => 'Window To',
            'confirm' => 'Confirm',
            'date_cre' => 'Date Cre',
            'culture' => 'Culture',
            'receiver' => 'Receiver',
            'phone' => 'Phone',
            'deleted' => 'Deleted',
            'arrived' => 'Arrived',
            'delete_date' => 'Delete Date',
            'delete_who' => 'Delete Who',
            'is_dirty' => 'Is Dirty',
        ];
    }
}
