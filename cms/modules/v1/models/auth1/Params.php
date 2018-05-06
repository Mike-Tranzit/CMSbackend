<?php
/**
 * Created by PhpStorm.
 * User: Mihail
 * Date: 24.03.2018
 * Time: 20:14
 */

namespace cms\modules\v1\models\auth;


class Params
{
    CONST MODEL_PARAMS = [
        'K7sQjA8PE' => [
            'login_field' => 'login',
            'table_name' => '\cms\modules\v1\models\base\Users',
            'table_path' => 'glonass.users'
        ]
    ];

    public static function PARAMS_LIST() {
        return self::MODEL_PARAMS;
    }
}
