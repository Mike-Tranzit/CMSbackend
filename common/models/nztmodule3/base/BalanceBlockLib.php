<?php

namespace common\models\nztmodule3\base;

use Yii;

/**
 * This is the model class for table "balance_block_lib".
 *
 * @property int $id
 * @property string $name
 */
class BalanceBlockLib extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'balance_block_lib';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 255],
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
        ];
    }
}
