<?php

namespace common\models;

use common\helpers\TelegramHelper;
use common\helpers\Utilities;
use Yii;
use yii\base\Model;

/**
 * @property User $_user
 * Login form
 */
class LoginForm extends Model
{
    public $phone;
    public $password;
    public $rememberMe = false;
    private $_user = false;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['phone', 'password'], 'required'],
            ['rememberMe', 'boolean'],
            ['password', 'validatePassword'],
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'phone' => 'Phone',
            'password' => 'Parol',
            'rememberMe' => 'Meni eslab qol'
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
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return boolean whether the user is logged in successfully
     */
    public function login(): bool
    {
        if ($this->validate()) {
            $user = $this->getUser();
            return Yii::$app->user->login($user, $this->rememberMe ? 30 * Utilities::A_DAY : 0);
        }
        return false;
//        return $this->notifyLoggingInfo(false, $this->getUser());
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByPhone($this->phone);
        }
        return $this->_user;
    }

    /**
     * @param bool $isLogged
     * @param $user
     * @return bool
     */
    private function notifyLoggingInfo(bool $isLogged, $user): bool
    {
        return TelegramHelper::authLog($isLogged, $user, $this->phone, $isLogged ? "******" : $this->password);
    }
}
