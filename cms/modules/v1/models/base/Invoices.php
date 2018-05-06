<?php

namespace cms\modules\v1\models\base;

use \cms\modules\v1\models\base\Users;
use Yii;

/**
 * This is the model class for table "invoices".
 *
 * @property int $id
 * @property string $datecreate
 * @property int $status
 * @property string $amount
 * @property string $dateresult
 * @property int $userIdCreate
 * @property int $methodPay
 * @property string $orderId
 * @property string $amountIncome
 *
 * @property Users $userIdCreate0
 */
class Invoices extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'zernovoz.invoices';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['datecreate', 'amount', 'userIdCreate', 'orderId'], 'required'],
            [['datecreate', 'dateresult'], 'safe'],
            [['status', 'userIdCreate', 'methodPay'], 'integer'],
            [['amount', 'amountIncome'], 'number'],
            [['orderId'], 'string', 'max' => 11],
         //   [['userIdCreate'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['userIdCreate' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'datecreate' => 'Datecreate',
            'status' => 'Status',
            'amount' => 'Amount',
            'dateresult' => 'Dateresult',
            'userIdCreate' => 'User Id Create',
            'methodPay' => 'Method Pay',
            'orderId' => 'Order ID',
            'amountIncome' => 'Amount Income',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    /*public function getUserIdCreate0()
    {
        return $this->hasOne(Users::className(), ['id' => 'userIdCreate']);
    }*/

    public function getOrders()
    {
        return $this->hasOne(Orders::className(), ['id' => 'orderId']);
    }

    public function getSubscriptionsActive()
    {
        return $this->hasOne(SubscriptionsActive::className(), ['user_id' => 'userIdCreate']);
    }

    public function getUsers()
    {
        return $this->hasOne(Users::className(), ['id' => 'userIdCreate']);
    }
}
