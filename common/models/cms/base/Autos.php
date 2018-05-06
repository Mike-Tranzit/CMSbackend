<?php

namespace common\models\cms\base;

use Yii;

/**
 * This is the model class for table "autos".
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
 * @property string $arrived
 * @property int $move_counter
 * @property int $is_dirty
 */
class Autos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cms.autos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['prov', 'trader', 'windows'], 'required'],
            [['prov', 'trader', 'confirm', 'culture', 'receiver', 'arrived', 'move_counter', 'is_dirty'], 'integer'],
            [['windows', 'window_from', 'window_to', 'date_cre'], 'safe'],
            [['phone'], 'string'],
            [['num_auto'], 'string', 'max' => 25],
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
            'arrived' => 'Arrived',
            'move_counter' => 'Move Counter',
            'is_dirty' => 'Is Dirty',
        ];
    }
}
