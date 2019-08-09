<?php

namespace common\models\nztmodule3\base;

use Yii;

/**
 * This is the model class for table "config".
 *
 * @property int $id
 * @property string $name
 * @property string $value
 * @property string $description
 * @property string $title
 * @property int $is_select
 */
class Config extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'config';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['description'], 'string'],
            [['name'], 'string', 'max' => 30],
            [['value'], 'string', 'max' => 255],
            [['value', 'title'], 'string', 'max' => 255],
            [['is_select'], 'string', 'max' => 1],
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
            'description' => 'Description',
            'title' => 'Title',
            'is_select' => 'Is Select',
        ];
    }
}
