<?php

namespace frontend\models\forms;

use himiklab\yii2\recaptcha\ReCaptchaValidator2;
use Yii;
use yii\base\Model;

/**
 * Set code form
 * @property string $first_name
 * @property string $last_name
 * @property string $middle_name
 * @property string $phone
 * @property string $email
 * @property string $message
 * @property string $recaptcha
 * @property string $address
 */
class RegistrationForm extends Model
{
    public $phone;
    public $first_name;
    public $last_name;
    public $middle_name;
    public $email;
    public $message;
    public $address;
    public $recaptcha;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['first_name','last_name','middle_name','phone','email','address'], 'required'],
            [['message','address','phone','first_name','last_name','middle_name'], 'string'],
            [['email'], 'email'],
            [['phone'], 'string','length' => 13],
            ['recaptcha', 'captcha', 'captchaAction' => 'site/captcha'],
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'city_id' => Yii::t('app', 'City ID'),
            'region_id' => Yii::t('app', 'Region ID'),
            'address' => Yii::t('app', 'Address'),
            'first_name' => Yii::t('app', 'First Name'),
            'last_name' => Yii::t('app', 'Last Name'),
            'middle_name' => Yii::t('app', 'Middle Name'),
            'birth_date' => Yii::t('app', 'Birth Date'),
            'phone' => Yii::t('app', 'Phone'),
            'message' => Yii::t('app', 'Message'),
        ];
    }
    /**
     * @param int $digits
     * @return int
     */
    public function generateNewCode($digits = 6)
    {
        return rand(pow(10, $digits - 1), pow(10, $digits) - 1);
    }


    /**
     * @param int $digits
     * @return int
     */
    public function getOTP($digits = 6)
    {
        $otp = $this->generateNewCode($digits);
        $this->setPassword($otp);
        return $otp;
    }

    /**
     * @return string
     */
    public function sendOTP()
    {
        $smsHelper = new SmsHelper(false, 1);
        return $smsHelper->sendSingleMessage($this->phone, 'Asaxiy.uz! Bir martalik tasdiqlash kodingiz : ' . $this->getOTP());
    }


}
