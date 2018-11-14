<?php

namespace cms\modules\v1\helpers;

class StringHelp
{

    public static function fioToBase($value){
        return mb_convert_case($value, MB_CASE_TITLE, "UTF-8");
    }

    public static function clearPhoneNumber($value){
        return  preg_replace("/[^0-9]/", "", $value);
    }
}