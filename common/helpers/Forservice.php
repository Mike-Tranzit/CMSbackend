<?php
/**
 * Created by PhpStorm.
 * User: PC
 * Date: 17.05.2018
 * Time: 17:10
 */

namespace common\helpers;


class Forservice
{
    public static function getContents($params,$url)
    {
            return @file_get_contents($url, false, stream_context_create(array(
                'http' => array(
                    'method'  => 'POST',
                    'header'  => 'Content-type: application/x-www-form-urlencoded',
                    'content' => http_build_query($params)
                )
            )));
    }

    public static function sms($message,$phone){
        $url = 'http://192.168.2.200:84/sendSms/?format=json';
        $params = array(
            'Phone' => $phone,
            'Message' => $message
        );

        $result = self::getContents($params, $url);
        return $result;
    }

}