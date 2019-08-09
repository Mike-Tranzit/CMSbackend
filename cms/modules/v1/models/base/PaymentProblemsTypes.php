<?php

namespace cms\modules\v1\models\base;

use Yii;

/**
 * This is the model class for table "payment_problems_types".
 *
 * @property int $id
 * @property string $title
 */
class PaymentProblemsTypes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'zernovoz.payment_problems_types';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['title'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(PaymentProblemsTypes::className(), ['id' => 'type_id']);
    }
}
