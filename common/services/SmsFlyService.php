<?php

namespace common\services;

use common\helpers\TelegramHelper;
use common\models\SmsCounter;

class SmsFlyService
{
    private const SMS_API_URL = "https://api.smsfly.uz/";

    /**
     * @return string
     */
    public function getToken()
    {
        $key = "1d62334f-b0db-11ec-8073-0242ac120002";
        return $key;
    }

    public function sendSmsToOnePhone($phone, $text)
    {
        $sms_counter = new SmsCounter();

        $fields = [
            "key" => $this->getToken(),
            "phone" => str_replace("+", "", $phone),
            "message" => $text
        ];
        $sms_counter = $sms_counter->getThisMonth(SmsCounter::MUROBAHA, SmsCounter::SMS_FLY);
        $sms_counter->updateAttributes(['count' => $sms_counter->count + 1]);
        return $this->runUrl($fields);
    }

    public function runUrl($fields)
    {
        $headers = array(
            'Content-Type: application/json'
        );
        $url = self::SMS_API_URL;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
//        curl_setopt($ch, CURLOPT_TIMEOUT, 10); // drop connection after 3 seconds
        $result = curl_exec($ch);
        $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if ($http_status != 200) {
            return false;
        }
        $telegram = new TelegramHelper(false);
        $telegram->sendMessage("Request -> URL : " . $url . json_encode($fields));
        $telegram->sendMessage("Response -> URL : " . $result);
        $result = json_decode($result, true);
        if (isset($result['success']) && $result['success'] == true)
            return true;
    }

}