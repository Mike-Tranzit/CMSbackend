<?php

namespace admin\modules\v1\models\base;

use Yii;

/**
 * This is the model class for table "usersmodule".
 *
 * @property int $id
 * @property string $login
 * @property string $password
 * @property string $last_in
 * @property string $ip
 * @property string $date_create
 * @property string $name
 * @property int $del
 * @property int $page_size
 * @property int $role
 * @property string $tel
 * @property string $email
 * @property string $last_out
 */
class Usersmodule extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'nztmodule3.usersmodule';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['last_in', 'date_create', 'last_out'], 'safe'],
            [['del', 'page_size', 'role'], 'integer'],
            [['login', 'email'], 'string', 'max' => 50],
            [['password', 'ip', 'name'], 'string', 'max' => 255],
            [['tel'], 'string', 'max' => 20],
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
            'ip' => 'Ip',
            'date_create' => 'Date Create',
            'name' => 'Name',
            'del' => 'Del',
            'page_size' => 'Page Size',
            'role' => 'Role',
            'tel' => 'Tel',
            'email' => 'Email',
            'last_out' => 'Last Out',
        ];
    }
}
