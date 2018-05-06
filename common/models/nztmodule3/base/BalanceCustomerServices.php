<?php

namespace common\models\nztmodule3\base;

use Yii;

/**
 * This is the model class for table "balance_customer_services".
 *
 * @property string $id
 * @property int $customer_id
 * @property int $service_id
 * @property int $blocking_id
 * @property string $last_writeoff_date
 */
class BalanceCustomerServices extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'nztmodule3.balance_customer_services';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['customer_id', 'service_id', 'last_writeoff_date'], 'required'],
            [['customer_id', 'service_id', 'blocking_id'], 'integer'],
            [['last_writeoff_date'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'customer_id' => 'Customer ID',
            'service_id' => 'Service ID',
            'blocking_id' => 'Blocking ID',
            'last_writeoff_date' => 'Last Writeoff Date',
        ];
    }


}
