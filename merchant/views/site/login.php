<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */
/* @var $project_name \common\models\ProjectName */

$this->title = 'Tizimga kirish';
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
            <div class="mx-auto login_content">
                <div class="login-register-page">
                    <!-- Welcome Text -->
                    <div class="asaxiy-logo-img">
                        <img src="/images/icon/asaxiy-logo.svg" alt="asaxiy-logo">
                    </div>
                    <div class="welcome-text">
<!--                        <h3>--><?php //= $project_name->login_name ?><!--</h3>-->
                        <span>Tizimdan foydalanish uchun, iltimos, avtorizatsiyadan o'ting</span>
                    </div>
                    <!-- Form -->
                    <?php $form = ActiveForm::begin(['id' => 'login-form', 'enableClientValidation' => false]); ?>
                    <p class="pl-10">Login</p>
                    <?= $form
                        ->field($model, 'username', $fieldOptions1)
                        ->label(false)
                        ->textInput(['placeholder' => 'Login', 'class' => 'input-text with-border', 'autocomplete' => 'new-username']) ?>

                    <?= $form
                        ->field($model, 'password', $fieldOptions2)
                        ->label(false)
                        ->textInput(['placeholder' => 'Parol', 'class' => 'input-text with-border', 'autocomplete' => 'new-password']) ?>

                    <?= $form
                        ->field($model, 'rememberMe', $fieldOptions3)
                        ->label(false)
                        ->checkbox(['id' => 'remember']) ?>

                    <!-- Button -->
                    <?= Html::submitButton('Kirish', ['class' => 'button full-width ripple-effect mt-10 login_button', 'name' => 'login-button']) ?>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    setTimeout(function() {
        $('.btn-show-pass').next('input').attr('type', 'password');
    }, 2000);
    document.addEventListener('DOMContentLoaded', function() {
        // Set the password field value to an empty string
        document.getElementsByName('LoginForm[username]')[0].value = '';
        document.getElementsByName('LoginForm[password]')[0].value = '';
    });
</script>