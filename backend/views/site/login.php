<?php

use common\models\LoginForm;
use common\models\ProjectName;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model LoginForm */
/* @var $project_name ProjectName */

$this->title = Yii::t('app', 'Tizimga kirish');
$fieldOptions1 = [
    'options' => ['class' => 'input-with-icon-left has-feedback'],
    'inputTemplate' => "<i class='icon-feather-user'></i>{input}"
];

$fieldOptions2 = [
    'options' => ['class' => 'input-with-icon-left has-feedback'],
    'inputTemplate' => "<span class='btn-show-pass'>🙉</span>{input}<i class='icon-material-outline-lock'></i>"
];

$fieldOptions3 = [
    'options' => ['class' => 'checkbox'],
    'inputTemplate' => "{input}<label for='remember'><span class='checkbox-icon'></span>Eslab qol</label>"
];
?>
<div class="login__block">
    <div class="container">
        <div class="row">
            <div class="login_content mx-auto">
                <div class="login-register-page">
                    <div class="logo w-100 d-flex justify-content-center mb-20">
                        <img src="/images/crm-logo.jpg">
                    </div>
                    <!-- Welcome Text -->
                    <div class="welcome-text">
                        <h3 style="font-family: Inter"><?= Yii::t('app', 'Добро пожаловать!') ?></h3>
                    </div>

                    <!-- Tab Panes -->
                    <div class="tab-content mt-4">
                        <!-- Email Login Form -->
                        <div class="tab-pane fade in active" id="phone-login">
                            <?php $form = ActiveForm::begin(['id' => 'login-form', 'enableClientValidation' => false]); ?>
                            <p class="pl-10"><?= Yii::t('app', 'Введите свой номер телефона') ?></p>
                            <?= $form
                                ->field($model, 'phone', $fieldOptions1)
                                ->label(false)
                                ->textInput([
                                    'class' => 'input-text with-border phone-input phone_input-login',
                                    'value' => '+998',
                                ]) ?>
                            <p class="pl-10"></p>
                            <?= $form
                                ->field($model, 'password', $fieldOptions2)
                                ->label(false)
                                ->textInput(['placeholder' => 'Parolni kiriting', 'class' => 'input-text with-border', 'autocomplete' => 'new-password']) ?>
                            <?= $form
                                ->field($model, 'rememberMe', $fieldOptions3)
                                ->label(false)
                                ->checkbox(['id' => 'remember']) ?>
                            <?= Html::submitButton('Kirish', ['class' => 'button full-width ripple-effect mt-10 login_button', 'name' => 'login-button']) ?>
                            <?php ActiveForm::end(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    setTimeout(function () {
        $('.btn-show-pass').next('input').attr('type', 'password');
    }, 2000);

    document.addEventListener('DOMContentLoaded', function () {
        document.getElementsByName('LoginForm[username]')[0].value = '';
        document.getElementsByName('LoginForm[password]')[0].value = '';
    });

    document.addEventListener('DOMContentLoaded', function () {
        function formatPhoneNumber(value) {
            value = value.replace(/\D/g, '');
            value = value.substring(0, 12);
            let formattedValue = '+' + value;
            return formattedValue;
        }

        const phoneInput = document.querySelector('.phone-input');
        phoneInput.addEventListener('input', function () {
            this.value = formatPhoneNumber(this.value);
        });
        phoneInput.addEventListener('keypress', function (e) {
            if (!/\d/.test(e.key) && e.key !== 'Backspace' && e.key !== 'Delete') {
                e.preventDefault();
            }
        });
    });

    function isNumeric(event) {
        return /\d/.test(event.key);
    }

    function setFocus(currentInput, nextIndex) {
        let inputs = document.getElementsByName(currentInput.name);

        if (currentInput.value === "" && nextIndex > 0) {
            inputs[nextIndex - 2].focus();
        } else if (nextIndex < inputs.length && currentInput.value !== "") {
            inputs[nextIndex].focus();
        }
    }

    document.getElementById('continue-button').addEventListener('click', function () {
        document.getElementById('counter-container').style.display = 'block';
        document.querySelector('.login_workify').style.display = 'block'
        document.querySelector('.workify_login-contract').style.display = 'flex';
        this.style.display = 'none';
    });
    function setHiddenInputValue() {
        let passwordInputs = document.getElementsByName('password');
        let hiddenInput = document.getElementById('password-hidden-input');
        let concatenatedValue = "";
        for (let i = 0; i < passwordInputs.length; i++) {
            concatenatedValue += passwordInputs[i].value;
        }
        hiddenInput.value = concatenatedValue;
        console.log(hiddenInput.value);
    }

    let passwordInputs = document.getElementsByName('password');
    for (let i = 0; i < passwordInputs.length; i++) {
        passwordInputs[i].addEventListener('input', setHiddenInputValue);
    }
    document.querySelector('.button_resend').addEventListener('click', function () {
        location.reload();
    });
</script>
