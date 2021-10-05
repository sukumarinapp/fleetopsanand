<?php

namespace App;

class SMSFleetops
{
    private static $key = "hawpdd9xh3zkpCof3grFhafKr";
    private static $sender_id = "FLEETOPS";
    public function __construct(){}

    public static function send($to,$msg)
    {
        $msg=urlencode($msg);
        $key =  self::$key;
        $sender_id =  self::$sender_id;
        $url = "https://apps.mnotify.net/smsapi?key=$key&to=$to&sender_id=$sender_id&msg=$msg";
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $sms_response = curl_exec($ch);
        #echo $sms_response;die;
        if (curl_errno($ch)) {
            //$error_msg = curl_error($ch);
        }
        curl_close($ch);
    }
}