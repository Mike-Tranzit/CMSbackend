<?php

namespace common\models\nztmodule3\base;

use Yii;

/**
 * This is the model class for table "objects".
 *
 * @property int $id
 * @property int $pid
 * @property int $status_m
 * @property int $status_person
 * @property int $status_auto
 * @property string $date_from
 * @property string $time_from
 * @property string $date_to
 * @property string $time_to
 * @property string $num_doc
 * @property string $num_auto
 * @property string $fio
 * @property int $firm
 * @property int $culture
 * @property int $station
 * @property double $mas
 * @property string $date_to_podskok
 * @property string $time_to_podskok
 * @property string $date_from_podskok
 * @property string $time_from_podskok
 * @property string $date_to_nzt
 * @property string $time_to_nzt
 * @property string $date_from_nzt
 * @property string $time_from_nzt
 * @property string $primech
 * @property string $date_cre
 * @property int $contract
 * @property int $contract_status
 * @property int $otkat
 * @property int $black_list
 * @property int $notice
 * @property string $tel
 * @property int $pinokb
 * @property int $pinokp
 * @property string $timepinokb
 * @property string $timepinokp
 * @property string $datepinokb
 * @property string $datepinokp
 * @property int $pinok
 * @property string $time_appro_to
 * @property string $date_appro_to
 * @property string $date_from_punkt
 * @property string $time_from_punkt
 * @property string $remont
 * @property int $remontstatus
 * @property int $remonttime
 * @property int $del В козине помечаются как 1
 * @property string $del_time
 * @property string $del_date
 * @property int $nat
 * @property int $glonass
 * @property int $nocash
 * @property int $is_nkhp
 * @property int $galina
 * @property int $isReturn
 * @property string $dateReturn
 * @property string $date_from_nat
 * @property string $orderFromStividor
 * @property string $date_weighing_start
 * @property string $date_weighing_end
 * @property int $provider
 * @property int $allow_stevedore_change
 * @property int $organization
 * @property int $operator
 * @property int $carrier
 * @property string $license_number
 *
 * @property Mototelecommain[] $mototelecommains
 * @property NkhpExt[] $nkhpExts
 * @property ObjectStatus[] $objectStatuses
 */
class Objects extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'objects';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pid', 'status_m', 'status_person', 'status_auto', 'firm', 'culture', 'station', 'contract', 'contract_status', 'otkat', 'black_list', 'notice', 'pinokb', 'pinokp', 'pinok', 'remontstatus', 'remonttime', 'del', 'nat', 'glonass', 'nocash', 'is_nkhp', 'galina', 'isReturn', 'provider', 'allow_stevedore_change', 'organization', 'operator', 'carrier'], 'integer'],
            [['date_from', 'time_from', 'date_to', 'time_to', 'date_to_podskok', 'time_to_podskok', 'date_from_podskok', 'time_from_podskok', 'date_to_nzt', 'time_to_nzt', 'date_from_nzt', 'time_from_nzt', 'date_cre', 'timepinokb', 'timepinokp', 'datepinokb', 'datepinokp', 'time_appro_to', 'date_appro_to', 'date_from_punkt', 'time_from_punkt', 'remont', 'del_time', 'del_date', 'dateReturn', 'date_from_nat', 'orderFromStividor', 'date_weighing_start', 'date_weighing_end'], 'safe'],
            [['num_doc', 'fio'], 'required'],
            [['num_doc', 'primech'], 'string'],
            [['mas'], 'number'],
            [['num_auto'], 'string', 'max' => 15],
            [['fio', 'tel'], 'string', 'max' => 255],
            [['license_number'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pid' => 'Pid',
            'status_m' => 'Status M',
            'status_person' => 'Status Person',
            'status_auto' => 'Status Auto',
            'date_from' => 'Date From',
            'time_from' => 'Time From',
            'date_to' => 'Date To',
            'time_to' => 'Time To',
            'num_doc' => 'Num Doc',
            'num_auto' => 'Num Auto',
            'fio' => 'Fio',
            'firm' => 'Firm',
            'culture' => 'Culture',
            'station' => 'Station',
            'mas' => 'Mas',
            'date_to_podskok' => 'Date To Podskok',
            'time_to_podskok' => 'Time To Podskok',
            'date_from_podskok' => 'Date From Podskok',
            'time_from_podskok' => 'Time From Podskok',
            'date_to_nzt' => 'Date To Nzt',
            'time_to_nzt' => 'Time To Nzt',
            'date_from_nzt' => 'Date From Nzt',
            'time_from_nzt' => 'Time From Nzt',
            'primech' => 'Primech',
            'date_cre' => 'Date Cre',
            'contract' => 'Contract',
            'contract_status' => 'Contract Status',
            'otkat' => 'Otkat',
            'black_list' => 'Black List',
            'notice' => 'Notice',
            'tel' => 'Tel',
            'pinokb' => 'Pinokb',
            'pinokp' => 'Pinokp',
            'timepinokb' => 'Timepinokb',
            'timepinokp' => 'Timepinokp',
            'datepinokb' => 'Datepinokb',
            'datepinokp' => 'Datepinokp',
            'pinok' => 'Pinok',
            'time_appro_to' => 'Time Appro To',
            'date_appro_to' => 'Date Appro To',
            'date_from_punkt' => 'Date From Punkt',
            'time_from_punkt' => 'Time From Punkt',
            'remont' => 'Remont',
            'remontstatus' => 'Remontstatus',
            'remonttime' => 'Remonttime',
            'del' => 'Del',
            'del_time' => 'Del Time',
            'del_date' => 'Del Date',
            'nat' => 'Nat',
            'glonass' => 'Glonass',
            'nocash' => 'Nocash',
            'is_nkhp' => 'Is Nkhp',
            'galina' => 'Galina',
            'isReturn' => 'Is Return',
            'dateReturn' => 'Date Return',
            'date_from_nat' => 'Date From Nat',
            'orderFromStividor' => 'Order From Stividor',
            'date_weighing_start' => 'Date Weighing Start',
            'date_weighing_end' => 'Date Weighing End',
            'provider' => 'Provider',
            'allow_stevedore_change' => 'Allow Stevedore Change',
            'organization' => 'Organization',
            'operator' => 'Operator',
            'carrier' => 'Carrier',
            'license_number' => 'License Number',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMototelecommains()
    {
        return $this->hasMany(Mototelecommain::className(), ['pid' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNkhpExts()
    {
        return $this->hasMany(NkhpExt::className(), ['pid' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getObjectStatuses()
    {
        return $this->hasMany(ObjectStatus::className(), ['pid' => 'id']);
    }
}
