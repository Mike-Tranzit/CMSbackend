<?php

namespace cms\modules\v1\helpers;

class StringHelp
{
    public static function fioToBase($value)
    { if (($__am_res = __amock_before(get_called_class(), __CLASS__, __FUNCTION__, array($value), true)) !== __AM_CONTINUE__) return $__am_res; 
        return mb_convert_case($value, MB_CASE_TITLE, 'UTF-8');
    }

    public static function clearPhoneNumber($value)
    { if (($__am_res = __amock_before(get_called_class(), __CLASS__, __FUNCTION__, array($value), true)) !== __AM_CONTINUE__) return $__am_res; 
        return  preg_replace('/[^0-9]/', '', $value);
    }
}