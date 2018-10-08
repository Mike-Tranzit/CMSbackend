<?php
/**
 * Created by PhpStorm.
 * User: Mihail
 * Date: 24.03.2018
 * Time: 20:14
 */

namespace common\models\auth;
class Params
{
    public static function PARAMS_LIST() {
        return [
            'K7sQjA8PE' => [
                'login_field' => 'login',
                'table_name' => '\cms\modules\v1\models\base\Users',
                'table_path' => 'glonass.users'
            ],
            'L4g4SER63' => [
                'login_field' => 'login',
                'table_name' => '\admin\modules\v1\models\base\Usersmodule',
                'table_path' => 'nztmodule3.usersmodule',
                'extra_sql' => '`role` in (7)'
            ]
        ];

    }

    public static function getParamsForModelCode($model_key, $extra_field = NULL)
    {
        foreach (self::PARAMS_LIST() as $key => $value) {
            if ($model_key === $key) {
                return $extra_field ? $value[$extra_field] : $value;
            }
        }
        return NULL;
    }
}