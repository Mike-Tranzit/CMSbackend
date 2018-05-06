<?php

namespace cms\modules\v1\models\base;

use Yii;

/**
 * This is the model class for table "mobile_registration".
 *
 * @property string $id
 * @property int $user_id
 * @property string $last_sms_date
 * @property string $activation_code
 * @property string $registration_date
 */
class MobileRegistration extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mobile_registration';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'activation_code'], 'required'],
            [['user_id'], 'integer'],
            [['last_sms_date', 'registration_date'], 'safe'],
            [['activation_code'], 'string', 'max' => 6],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'last_sms_date' => 'Last Sms Date',
            'activation_code' => 'Activation Code',
            'registration_date' => 'Registration Date',
        ];
    }
}
