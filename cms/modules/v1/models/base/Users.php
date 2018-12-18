<?php

namespace cms\modules\v1\models\base;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $login
 * @property string $password
 * @property string $last_in
 * @property string $name
 * @property int $admin
 * @property int $activ Вход с СМС, 0 - да, 1 - нет
 * @property string $generate
 * @property int $isProvider 0 - клиент, 1 - Порт-Транзит, 2 - Южные технологии
 * @property int $role 1- обычный пользователь, 2-ЮТ, 3-Мы
 * @property int $confirm
 * @property string $company
 * @property string $email
 * @property string $skype
 * @property int $occupation
 * @property string $status_id vip status = 2
 * @property string $balance
 * @property string $status_expiry
 * @property string $show_nat_services
 * @property string $working_with_nds
 * @property string $company_id
 * @property string $place
 * @property string $place_code
 * @property string $region
 * @property string $region_code
 * @property double $rating
 * @property int $has_docs
 * @property int $forum_blocked
 * @property string $forum_block_expiry
 *
 * @property Token[] $tokens
 */
class Users extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'glonass.users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['last_in', 'status_expiry', 'forum_block_expiry'], 'safe'],
            [['admin', 'activ', 'isProvider', 'role', 'confirm', 'occupation', 'status_id', 'show_nat_services', 'working_with_nds', 'company_id', 'has_docs', 'forum_blocked'], 'integer'],
            [['balance', 'rating'], 'number'],
            [['login'], 'string', 'max' => 50],
            [['password', 'name', 'generate', 'company', 'email', 'skype', 'place', 'region'], 'string', 'max' => 255],
            [['place_code', 'region_code'], 'string', 'max' => 13],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'login' => 'Login',
            'password' => 'Password',
            'last_in' => 'Last In',
            'name' => 'Name',
            'admin' => 'Admin',
            'activ' => 'Activ',
            'generate' => 'Generate',
            'isProvider' => 'Is Provider',
            'role' => 'Role',
            'confirm' => 'Confirm',
            'company' => 'Company',
            'email' => 'Email',
            'skype' => 'Skype',
            'occupation' => 'Occupation',
            'status_id' => 'Status ID',
            'balance' => 'Balance',
            'status_expiry' => 'Status Expiry',
            'show_nat_services' => 'Show Nat Services',
            'working_with_nds' => 'Working With Nds',
            'company_id' => 'Company ID',
            'place' => 'Place',
            'place_code' => 'Place Code',
            'region' => 'Region',
            'region_code' => 'Region Code',
            'rating' => 'Rating',
            'has_docs' => 'Has Docs',
            'forum_blocked' => 'Forum Blocked',
            'forum_block_expiry' => 'Forum Block Expiry',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTokens()
    {
        return $this->hasMany(\common\models\auth\Token::className(), ['user_id' => 'id']);
    }
}
