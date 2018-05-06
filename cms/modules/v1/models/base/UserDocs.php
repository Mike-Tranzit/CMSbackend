<?php

namespace cms\modules\v1\models\base;

use Yii;

/**
 * This is the model class for table "user_docs".
 *
 * @property string $user_id
 * @property string $company_name
 * @property string $inn
 * @property string $place
 * @property string $kpp
 * @property string $ogrn
 */
class UserDocs extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'glonass.user_docs';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'company_name', 'inn'], 'required'],
            [['user_id'], 'integer'],
            [['company_name', 'inn', 'place', 'kpp', 'ogrn'], 'string', 'max' => 255],
            [['user_id'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'company_name' => 'Company Name',
            'inn' => 'Inn',
            'place' => 'Place',
            'kpp' => 'Kpp',
            'ogrn' => 'Ogrn',
        ];
    }
}
