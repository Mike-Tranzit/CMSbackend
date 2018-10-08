<?php

namespace common\models\nztmodule3\base;

use Yii;

/**
 * This is the model class for table "debtor".
 *
 * @property int $id
 * @property string $plate
 * @property int $sum
 * @property int $paid_sum
 * @property string $date_create
 * @property string $date_last_pay
 * @property int $status 0 - активна, 1 - не активна
 * @property string $description
 */
class Debtor extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'nztmodule3.debtor';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sum', 'paid_sum', 'status'], 'integer'],
            [['date_create', 'date_last_pay'], 'safe'],
            [['description'], 'string'],
            [['plate'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'plate' => 'Plate',
            'sum' => 'Sum',
            'paid_sum' => 'Paid Sum',
            'date_create' => 'Date Create',
            'date_last_pay' => 'Date Last Pay',
            'status' => 'Status',
            'description' => 'Description',
        ];
    }
}
