<?php

use backend\models\forms\UserRegisterForm;
use common\models\Company;
use common\models\constants\UserRole;
use common\models\constants\UserStatus;
use common\models\Market;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model UserRegisterForm */
/* @var $form yii\widgets\ActiveForm */

$admin = Yii::$app->user->identity;
?>

<?php $form = ActiveForm::begin(); ?>
<div class="row">
    <div class="col-md-12">
        <div class="row create__user-form">
            <h3 class="title w-100"><?= Yii::t('app', 'Shaxsiy ma’lumotlar') ?></h3>
            <div class="col-md-6">
                <?php if (Yii::$app->user->identity->is_creator) echo $form->field($model, 'company_id')->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(Company::findActive()->all(), 'id', 'name'),
                    'language' => 'en',
                    'options' => ['placeholder' => Yii::t('app', 'Select ...')],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]); ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'market_id')->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(Market::findActive()->all(), 'id', 'name'),
                    'language' => 'en',
                    'options' => ['placeholder' => Yii::t('app', 'Select ...')],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]) ?>
            </div>
            <div class="col-md-6">
                <?php if ($admin->is_admin) echo $form->field($model, 'phone')->textInput([
                    'maxlength' => 13,
                    'class' => 'with-border',
                    'placeholder' => '+998 000 00 00',
                    'onfocus' => "if(this.value === '') this.value = '+998';",
                    'oninput' => "if(this.value.indexOf('+998') !== 0) this.value = '+998' + this.value.replace(/[^0-9]/g, '').slice(3);",
                ]) ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'full_name')->textInput(['maxlength' => true, 'class' => 'with-border']) ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'status')->dropDownList(UserStatus::getList()) ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'role')->dropDownList(UserRole::getList()) ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'password')->textInput([
                    'type' => 'password',
                    'maxlength' => true,
                    'autocomplete' => 'off',
                    'class' => 'password-id with-border',
                    'placeholder' => Yii::t('app', 'Parolni kiriting')
                ]) ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'confirm_password')->textInput([
                    'type' => 'password',
                    'maxlength' => true,
                    'autocomplete' => 'off',
                    'class' => 'password-id with-border',
                    'placeholder' => Yii::t('app', 'Parolni kiriting')
                ]) ?>
            </div>
            <div class="col-md-6">
                <?php if ($model->id !== null)
                    echo $form->field($model, 'change_password')->checkbox(['class' => 'change-password']);
                ?>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="w-100 d-flex justify-content-center align-items-center buttons__form">
            <button class="cancel__button"><?= Yii::t('app', 'Bekor qilish') ?></button>
            <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'button ripple-effect  update_save-button']) ?>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>

<?php
$js = <<<JS
if($('.change-password').length > 0)
    $('.password-id').attr("disabled", "disabled")

$('.change-password').on("click", function(){
     let value = $('.change-password').is(':checked');
     if(value) 
         $('.password-id').removeAttr("disabled")
     else 
         $('.password-id').attr("disabled", "disabled")
});
JS;
$this->registerJs($js);
?>
