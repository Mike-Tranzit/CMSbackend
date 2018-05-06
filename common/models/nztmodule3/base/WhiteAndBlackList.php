<?php

namespace common\models\nztmodule3\base;

use Yii;

/**
 * This is the model class for table "white_and_black_list".
 *
 * @property int $id
 * @property string $num_auto
 * @property string $time_out
 * @property string $time_add
 * @property int $non_time Бессрочно = 1 
 * @property string $textp
 * @property int $wh 1- белый список 2 - черный список
 * @property int $power 1- только предупредить
 * @property int $action 1 - предупрежден
 * @property int $who 1- ПОРТТРАНЗИТ, 2-Жмырко, 3- Петренко, 4- Афанасьев, 5- Зеленский, -6 - автоматом НКХП
 * @property string $texts
 */
class WhiteAndBlackList extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'nztmodule3.white_and_black_list';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['num_auto', 'textp'], 'required'],
            [['time_out', 'time_add'], 'safe'],
            [['non_time', 'wh', 'power', 'action', 'who'], 'integer'],
            [['textp', 'texts'], 'string'],
            [['num_auto'], 'string', 'max' => 20],
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
            'time_out' => 'Time Out',
            'time_add' => 'Time Add',
            'non_time' => 'Non Time',
            'textp' => 'Textp',
            'wh' => 'Wh',
            'power' => 'Power',
            'action' => 'Action',
            'who' => 'Who',
            'texts' => 'Texts',
        ];
    }
}
