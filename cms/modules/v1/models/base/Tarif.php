<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tarif".
 *
 * @property int $id
 * @property string $name
 * @property int $value
 * @property int $count_month
 * @property string $title
 * @property string $value_text
 */
class Tarif extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'zernovoz.tarif';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['value', 'count_month'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['title', 'value_text'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'value' => 'Value',
            'count_month' => 'Count Month',
            'title' => 'Title',
            'value_text' => 'Value Text',
        ];
    }
}
