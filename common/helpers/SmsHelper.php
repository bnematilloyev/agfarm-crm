<?php


namespace common\helpers;


use common\models\Company;
use common\models\Customer;
use common\models\PlayMobileAccount;
use common\models\Setting;
use common\models\SmsCounter;

/**
 * This is the model class for table "SMS".
 *
 * @property string $lang
 * @property string $token
 * @property string $prefix
 *
 * @property Company $company
 * @property PlayMobileAccount $playMobileAccount
 */
class SmsHelper
{
    private $sms_fly_token;
    const SMS_FLY_URL = "https://api.smsfly.uz/send";
    const SMS_FLY_BULK_URL = self::SMS_FLY_URL . "-bulk";
    const SMS_FLY_BULK_TEMPLATE_URL = self::SMS_FLY_BULK_URL . "-template";


    /**
     * SmsHelper constructor.
     */
    public function __construct()
    {
        $sms_fly = PlayMobileAccount::findOne(['username' => 'SMS-FLY-TOKEN']);
        if ($sms_fly != null)
            $this->sms_fly_token = "aeab567f-60ca-11ed-b8e4-0242ac120003";
    }

    /**
     * @param $phone
     * @param $msg
     * @return string
     */
    public function sendSingleMessage($phone, $msg)
    {
        $phone = str_replace("+", "", $phone);
        if ($this->checkIsBlockedPhone($phone))
            return false;
//        if ($phone == "998000000000" || str_starts_with($phone, "99894") || str_starts_with($phone, "99893"))
//            return false;
        return $this->sendSingleMessageWithSmsFly($phone, $msg);
    }

    /**
     * @param $phone
     * @param $msg
     * @return string
     */
    public function sendSingleMessageWithSmsFly($phone, $msg)
    {
        $sms_counter = new SmsCounter();
        $fields = array(
            'key' => $this->sms_fly_token,
            'phone' => $phone,
            'message' => $msg
        );

        $sms_counter = $sms_counter->getThisMonth(SmsCounter::MUROBAHA, SmsCounter::SMS_FLY);
        $sms_counter->updateAttributes(['count' => $sms_counter->count + 1]);


        return $this->runUrlWithSmsFLy($fields);
    }

    /**
     * @param $phones
     * @param $msg
     * @return string
     */
    public function sendMultipleMessageSmsFly($phones, $msg)
    {
        $new_phones = [];
        $cnt = 0;
        foreach ($phones as $phone) {
            $cnt++;
            $phone = str_replace("+", "", $phone);
            $new_phones[] = $phone;
            if ($cnt > 9999) {
                $this->sendPackedMessageSmsFly($new_phones, $msg);
                $new_phones = [];
                $cnt = 0;
                sleep(10);
            }
        }
        return $cnt > 0 ? $this->sendPackedMessageSmsFly($new_phones, $msg) : true;
    }

    /**
     * @param $messages
     * @param $msg
     * @return string
     */
    public function sendPackedMessageSmsFly($phones, $msg)
    {
        $sms_counter = new SmsCounter();
        $fields = array(
            'key' => $this->sms_fly_token,
            "message" => $msg,
            "phones" => $phones
        );
        $cnt = count($phones);
        if ($cnt > 0) {
            $sms_counter = $sms_counter->getThisMonth(SmsCounter::MUROBAHA, SmsCounter::SMS_FLY);
            $sms_counter->addCount($cnt);
        }
        return $this->runUrlWithSmsFly($fields, self::SMS_FLY_BULK_URL);
    }

    /**
     * @param $messages
     * @param $msg
     * @return string
     */
    public function sendBulkAsProxy($fields)
    {
        return $this->runUrlWithSmsFly($fields, self::SMS_FLY_BULK_URL);
    }

    /**
     * @param $messages
     * @param $msg
     * @return string
     */
    public function sendSingleAsProxy($fields)
    {
        return $this->runUrlWithSmsFly($fields);
    }

    /**
     * @param $text
     * @param $debt
     * @param $day
     * @param $phone
     * @return string
     */
    public function sendSmsToNC($text, $debt, $day, $phone)
    {
        $text = str_replace("{debt}", $debt, $text);
        $text = str_replace("{day}", $day, $text);
        $this->sendSingleMessage($phone, $text);
        return $text;
    }

    /**
     * @param $fields
     * @return string
     */
    public function runUrlWithSmsFly($fields, $url = self::SMS_FLY_URL)
    {
        $headers = array(
            'Content-Type: application/json'
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if ($http_status == 200) {
            return false;
        }

        return true;
    }

    public function sendWithdrawnSms($loandId, $phone, $pan, $amount)
    {
        if ($amount > 16000)
            return $this->sendSingleMessage($phone, "Hurmatli {$loandId}-xaridor\nsizning {$pan} kartangizdan\nbizdagi shartnomalaringiz uchun\n{$amount} so'm pul yechib oldik\nTel: " . $this->getPhone($loandId));
        return false;
    }

    private function getPhone($loandId)
    {
        $customer = Customer::findOne($loandId);
        if ($customer != null)
            return $customer->getMarket_phone();
        return "712000105";
    }

    public function sendUzumNasiyaCanceledMessage(string $phone)
    {
        return $this->sendSingleMessage($phone, "Arizangiz \"UzumNasiya\" tomonidan bekor qilindi.\nVasha zayavka bila otmenena \"UzumNasiya\". Po voprosam vi mojete obrashatsya po telefonu +998 78 777 15 15");
    }

    private function checkIsBlockedPhone($phone)
    {
        return in_array($phone, Setting::getArray("blocked-phones")) || in_array(substr($phone, -9), Setting::getArray("blocked-phones"));
    }
}
