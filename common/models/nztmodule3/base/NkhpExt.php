<?php

namespace common\models\nztmodule3\base;

use Yii;

/**
 * This is the model class for table "nkhp_ext".
 *
 * @property int $id
 * @property int $pid
 * @property double $brutto
 * @property string $trailer
 * @property string $region_trailer
 * @property int $user_pid
 * @property string $date_doc
 *
 * @property Objects $p
 */
class NkhpExt extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'nkhp_ext';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pid'], 'required'],
            [['pid', 'user_pid'], 'integer'],
            [['brutto'], 'number'],
            [['date_doc'], 'safe'],
            [['trailer'], 'string', 'max' => 20],
            [['region_trailer'], 'string', 'max' => 4],
            [['pid'], 'exist', 'skipOnError' => true, 'targetClass' => Objects::className(), 'targetAttribute' => ['pid' => 'id']],
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
            'brutto' => 'Brutto',
            'trailer' => 'Trailer',
            'region_trailer' => 'Region Trailer',
            'user_pid' => 'User Pid',
            'date_doc' => 'Date Doc',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getP()
    {
        return $this->hasOne(Objects::className(), ['id' => 'pid']);
    }
}
