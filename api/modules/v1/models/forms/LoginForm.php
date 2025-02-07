<?php
/**
 * Created by PhpStorm.
 * User: Husayn Hasanov
 */

namespace api\modules\v1\models\forms;

use api\modules\admin\service\SmsService;
use common\models\User;
use Yii;
use yii\base\Model;

/**
 * Login form
 */
class LoginForm extends Model
{
    public $phone;
    public $password;
    public $rememberMe = true;

    private $_customer;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['phone', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            [['phone'], 'match', 'pattern' => '/((\+998)|0)[-]?[0-9]{9}/'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $smsService = new SmsService();
            if (!$smsService->validatePhone($this->phone, $this->password)) {
                $this->addError($attribute, Yii::t('api', "Verification code is not valid"));
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return array|false whether the user is logged in successfully
     */
    public function login()
    {
        if (!$this->validate()) {
            return false;
        }
        $customer = $this->getUser();
        if ($customer == null) {
            return false;
        }
        if (!Yii::$app->user->login($customer)) {
            return false;
        }
        return Yii::$app->jwtService->getTokenResult($this->rememberMe);
    }

    protected function getUser()
    {
        if ($this->_customer === null) {
            $this->_customer = User::findByPhone($this->phone);
        }
        return $this->_customer;
    }
}
