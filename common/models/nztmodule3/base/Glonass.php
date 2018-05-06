<?php

namespace common\models\nztmodule3\base;

use Yii;

/**
 * This is the model class for table "glonass".
 *
 * @property int $id
 * @property string $num_auto
 * @property string $dates
 * @property string $description
 * @property int $flag
 * @property string $date_flag
 * @property string $fio
 * @property string $tel1
 * @property string $tel
 * @property int $alarm1
 * @property string $alarm1_date
 * @property int $alarm2
 * @property string $alarm2_date
 * @property int $alarm3
 * @property string $alarm3_date
 * @property int $black
 * @property string $black_date
 * @property int $who_black
 * @property string $why_black
 * @property int $700rub
 * @property string $700rubdates
 * @property string $device_id
 * @property string $device_pass
 * @property int $deleted Состояние: 0 - используется, 1 - не используется
 * @property string $subject
 * @property int $provider Поставщик устройств:
 0 - Сочи
 1- Автограф
 * @property string $balance
 * @property string $delete_date
 * @property string $only_owner_can_confirm
 * @property int $userId
 * @property int $dispatcherId
 * @property string $lat
 * @property string $lon
 * @property string $date_last_coordinate
 * @property int $zoneId
 */
class Glonass extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'glonass';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['num_auto', 'dates'], 'required'],
            [['dates', 'date_flag', 'alarm1_date', 'alarm2_date', 'alarm3_date', 'black_date', '700rubdates', 'delete_date', 'date_last_coordinate'], 'safe'],
            [['description', 'why_black', 'subject'], 'string'],
            [['flag', 'alarm1', 'alarm2', 'alarm3', 'black', 'who_black', '700rub', 'device_id', 'deleted', 'provider', 'only_owner_can_confirm', 'userId', 'dispatcherId', 'zoneId'], 'integer'],
            [['balance', 'lat', 'lon'], 'number'],
            [['num_auto'], 'string', 'max' => 25],
            [['fio'], 'string', 'max' => 100],
            [['tel1', 'tel'], 'string', 'max' => 12],
            [['device_pass'], 'string', 'max' => 8],
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
            'dates' => 'Dates',
            'description' => 'Description',
            'flag' => 'Flag',
            'date_flag' => 'Date Flag',
            'fio' => 'Fio',
            'tel1' => 'Tel1',
            'tel' => 'Tel',
            'alarm1' => 'Alarm1',
            'alarm1_date' => 'Alarm1 Date',
            'alarm2' => 'Alarm2',
            'alarm2_date' => 'Alarm2 Date',
            'alarm3' => 'Alarm3',
            'alarm3_date' => 'Alarm3 Date',
            'black' => 'Black',
            'black_date' => 'Black Date',
            'who_black' => 'Who Black',
            'why_black' => 'Why Black',
            '700rub' => '700rub',
            '700rubdates' => '700rubdates',
            'device_id' => 'Device ID',
            'device_pass' => 'Device Pass',
            'deleted' => 'Deleted',
            'subject' => 'Subject',
            'provider' => 'Provider',
            'balance' => 'Balance',
            'delete_date' => 'Delete Date',
            'only_owner_can_confirm' => 'Only Owner Can Confirm',
            'userId' => 'User ID',
            'dispatcherId' => 'Dispatcher ID',
            'lat' => 'Lat',
            'lon' => 'Lon',
            'date_last_coordinate' => 'Date Last Coordinate',
            'zoneId' => 'Zone ID',
        ];
    }
}
