<?php

namespace common\models\nztmodule3\base;
use common\models\nztmodule3\base\BalanceBlockLib;
use Yii;

/**
 * This is the model class for table "balance_blockings".
 *
 * @property string $id
 * @property int $customer_service_id
 * @property int $block_type
 * @property string $date_block
 * @property string $date_unblock
 */
class BalanceBlockings extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'nztmodule3.balance_blockings';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['customer_service_id', 'block_type', 'date_block'], 'required'],
            [['customer_service_id', 'block_type'], 'integer'],
            [['date_block', 'date_unblock'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'customer_service_id' => 'Customer Service ID',
            'block_type' => 'Block Type',
            'date_block' => 'Date Block',
            'date_unblock' => 'Date Unblock',
        ];
    }

    public function getBalanceBlockLib()
    {
        return $this->hasOne(BalanceBlockLib::className(), ['id' => 'block_type']);
    }
}
