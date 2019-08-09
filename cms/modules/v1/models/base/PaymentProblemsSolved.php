<?php

namespace cms\modules\v1\models\base;

use Yii;

/**
 * This is the model class for table "payment_problems_solved".
 *
 * @property int $id
 * @property string $description
 * @property int $type_id
 * @property int $user_id
 * @property string $date_of_decision
 * @property string $date_task_close
 */
class PaymentProblemsSolved extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'zernovoz.payment_problems_solved';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description'], 'string'],
            [['type_id', 'user_id', 'date_of_decision', 'date_task_close'], 'required'],
            [['type_id', 'user_id'], 'integer'],
            [['date_of_decision', 'date_task_close'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'description' => 'Description',
            'type_id' => 'Type ID',
            'user_id' => 'User ID',
            'date_of_decision' => 'Date Of Decision',
            'date_task_close' => 'Date Task Close',
        ];
    }
}
