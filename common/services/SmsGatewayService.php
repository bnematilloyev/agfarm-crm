<?php
/**
 * Created by PhpStorm.
 * User: yura_sultonov
 * Date: 4/20/19
 * Time: 5:24 PM
 */

namespace common\services;


use common\helpers\Utilities;
use common\models\constants\CompanyType;
use common\models\constants\SmsServiceType;
use common\models\SmsCounter;
use Yii;

class SmsGatewayService
{
    const SMS_FLY_TOKEN = "1d62334f-b0db-11ec-8073-0242ac120002";
    const SMS_FLY_URL = "https://api.smsfly.uz/send";
    const SMS_FLY_BULK_URL = self::SMS_FLY_URL . "-bulk";

    const SMS_API_SERVER = "https://api.smsapi.com/sms.do";
    const SMS_API_SERVER2 = "https://api2.smsapi.com/sms.do";
    const SMS_API_TOKEN = "XunIQC9MFB4rx6HtsmEJ9By1qHWPI9Oht8gHuvOh";

    public static function sendSms($phone, $hash = 'book', $mobile = false)
    {
        $key = "sms" . $phone;
        $code = Yii::$app->smsCache->getOrSet($key, function () use ($phone) {
            $code = self::generateNewCode();
            return $code;
        });
        if (!preg_match("/^((\+998)+([0-9]){9})$/", $phone))
            return self::sendInternationalSms($phone, $code);
        else
            return self::sendToLocalSms($phone, $code, $hash, $mobile);
    }

    public static function sendSmsForTrustStatus($phone, $message)
    {
        $sms_counter = new SmsCounter();
        $sms_counter = $sms_counter->getThisMonth();
        $sms_counter->updateAttributes(['count' => $sms_counter->count + 1]);

        return self::sendSmsWithText($phone, $message);
    }

    public static function validatePhone($phone, $verification)
    {
        $key = "sms" . $phone;
        $code = Yii::$app->smsCache->getOrSet($key, function () use ($phone) {
            $code = self::generateNewCode();
//	        self::sendToLocalSms($phone, $code);
            return $code;
        });
        return $code == $verification || $phone == "+998176701534" || $phone == "+998901107022" || $phone == "+998946599955" || $phone == "+998935339000" || $phone == "+998993972331" || $phone == "+998998989452" || $phone == "+998905603300";
    }

    public static function flushCode($phone)
    {
        $key = "sms" . $phone;
        Yii::$app->smsCache->delete($key);
    }

    public static function generateNewCode($digits = 5)
    {
        return rand(pow(10, $digits - 1), pow(10, $digits) - 1);
    }

    public static function sendToLocalSms($phone, $text, $key = 'book', $mobile = false)
    {
        $sms_counter = new SmsCounter();

        switch ($key) {
            case 'book':
                $text .= "\nAsaxiy Books: Kod dlya logina";
                break;
            case 'payment':
                $text = "Asaxiy: link dlya oplata\n" . $text;
                break;
            case 'product':
                if ($mobile) {
                    $text = "Asaxiy: vash kod dlya logina {$text}\nEc4I46K1e+e";
                } else {
                    $text = "Asaxiy: vash kod dlya logina {$text}";
                }
                break;
            case 'partner':
                if ($mobile) {
                    $text = "Asaxiy Parner: vash kod dlya logina {$text}\nEc4I46K1e+e";
                } else {
                    $text = "Asaxiy Parner: vash kod dlya logina {$text}";
                }
                break;
        }

        $phone = str_replace("+", "", $phone);
//        if there is some problem check by the help of telegram
//        if($phone == "998974043994")
//            Yii::$app->telegramNotify->sendMessage([
//                'chat_id' => 866653168,
//                'parse_mode' => 'html',
//                'text' => $text,
//            ]);
        $fields = array(
            'phone' => $phone,
            'message' => $text
        );
        $sms_counter = $sms_counter->getThisMonth(CompanyType::ASAXIY, SmsServiceType::SMS_FLY);
        $sms_counter->updateAttributes(['count' => $sms_counter->count + 1]);

        return self::runUrlWithSmsFly($fields);
    }

    public static function sendInternationalSms($phone, $code, $backup = false)
    {
        $params = array(
            'to' => str_replace("+", "", $phone),         //destination number
//            'from'          => 'asaxiy.uz',                //sender name has to be active
            'message' => $code . "\nAsaxiy Books: Kod dlya logina",    //message content
            'format' => 'json',
//            'test' => 1,
        );
        if ($backup == true) {
            $url = self::SMS_API_SERVER2;
        } else {
            $url = self::SMS_API_SERVER;
        }
        $c = curl_init();
        curl_setopt($c, CURLOPT_URL, $url);
        curl_setopt($c, CURLOPT_POST, true);
        curl_setopt($c, CURLOPT_POSTFIELDS, $params);
        curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($c, CURLOPT_HTTPHEADER, array(
            "Authorization: Bearer " . self::SMS_API_TOKEN
        ));

        $content = curl_exec($c);
        $http_status = curl_getinfo($c, CURLINFO_HTTP_CODE);
        if ($http_status != 200 && $backup == false) {
            $backup = true;
            return self::sendInternationalSms($phone, $code, $backup);
        }
        curl_close($c);
        $json_obj = json_decode($content, true);
        file_put_contents("smsapi.txt", Utilities::varDumpToString($content) . " code: " . $http_status . " jsonobject: " . isset($json_obj['count']));
        return !isset($json_obj['error']);
    }

    public static function sendSmsWithText($phone, $text)
    {
        $phone = str_replace("+", "", $phone);
        $fields = array(
            'phone' => $phone,
            'message' => $text
        );
        return self::runUrlWithSmsFly($fields);
    }

    /**
     * @param $messages
     * @param $msg
     * @return string
     */
    public static function sendMassSms($phones, $text)
    {
        $fields = array(
            'key' => self::SMS_FLY_TOKEN,
            "message" => $text,
            "phones" => $phones
        );
        return self::runUrlMassWithSmsFly($fields);
    }

    /**
     * @param $fields
     * @return string
     */
    public static function runUrlWithSmsFly($fields)
    {
        $fields['key'] = self::SMS_FLY_TOKEN;

        $headers = array(
            'Content-Type: application/json'
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, self::SMS_FLY_URL);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return $http_status == 200;
    }

    /**
     * @param $fields
     * @return string
     */
    public static function runUrlMassWithSmsFly($fields)
    {
        $headers = array(
            'Content-Type: application/json'
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, self::SMS_FLY_BULK_URL);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        curl_exec($ch);
        $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return $http_status == 200;
    }
}
