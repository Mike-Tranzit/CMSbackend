<?php

namespace common\models\auth\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\db\ActiveRecord;
/**
 * This is the model class for table "token".
 *
 * @property int $id
 * @property int $user_id
 * @property string $token
 * @property string $expired_at
 * @property string $model_name
 * @property string $created_at
 * @property string $updated_at
 * @property string $firebase_token
 * @property string $salt
 */
class Token extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'glonass.token';
    }

    public function behaviors()
    {
        return [
            'timestamp' => [
            'class' => TimestampBehavior::className(),
            'attributes' => [
                ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
            ],
            'value' => new Expression('NOW()')
            ]
        ];
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'token', 'expired_at', 'model_name', 'salt'], 'required'],
            [['user_id'], 'integer'],
            [['token', 'firebase_token'], 'string'],
            [['expired_at'], 'safe'],
            [['model_name'], 'string', 'max' => 255],
            [['salt'], 'string', 'max' => 10],
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
            'token' => 'Token',
            'expired_at' => 'Expired At',
            'model_name' => 'Model Name',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
