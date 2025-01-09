<?php
/* @var $this yii\web\View */

/** @var \frontend\models\forms\RegistrationForm $model */

use yii\captcha\Captcha;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->title = "Bog'lanish";
?>
<!--page title start-->

<section class="page-title overflow-hidden text-center light-bg bg-contain animatedBackground"
         data-bg-img="/images/pattern/05.png">
    <div class="page-title-pattern"><img class="img-fluid" src="/images/bg/06.png" alt=""></div>
</section>

<!--page title end-->


<!--body content start-->

<div class="page-content">

    <!--contact start-->
    <?php $form = ActiveForm::begin(['id' => 'login-form', 'enableClientValidation' => false, 'options' => ['autocomplete' => 'off']]); ?>
    <section class="contact-1" data-bg-img="/images/pattern/02.png">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-xxl-9 col-lg-10 col-md-11 mx-auto">
                    <div class="section-title mb-2 text-center">
                        <h2 class="title d-inline-flex"><?=Yii::t('app','Ariza qoldirish')?></php></h2>
                    </div>
                    <div class="contact-main row">
                            <div class="col-sm-6">
                                <?= $form->field($model, 'first_name')->textInput(['maxlength' => true])->label($model->getAttributeLabel('first_name') . '<span style="color: red">*</span>') ?>
                            </div>
                            <div class="col-sm-6">
                                <?= $form->field($model, 'last_name')->textInput(['maxlength' => true])->label($model->getAttributeLabel('last_name') . '<span style="color: red">*</span>') ?>
                            </div>
                            <div class="col-sm-6">
                                <?= $form->field($model, 'middle_name')->textInput(['maxlength' => true])->label($model->getAttributeLabel('middle_name') . '<span style="color: red">*</span>') ?>
                            </div>
                            <div class="col-sm-6">
                                <?= $form->field($model, 'email')->textInput(['maxlength' => true])->label($model->getAttributeLabel('email') . '<span style="color: red">*</span>') ?>
                            </div>
                            <div class="col-sm-6">
                                <?= $form->field($model, 'phone')->widget(\yii\widgets\MaskedInput::className(), [
                                    'mask' => ['+998999999999'],
                                    'options' => [
                                        'class' => 'form-control autoff',
                                        'maxlength' => 13,
                                        'minlength' => 13,
                                    ],
                                    'clientOptions' => [
                                        'greedy' => false
                                    ]
                                ]) ?>
                            </div>
                        <div class="col-sm-6">
                            <?= $form->field($model, 'address')->textInput(['maxlength' => true])->label($model->getAttributeLabel('address') . '<span style="color: red">*</span>') ?>
                        </div>
                            <div class="col-md-12">
                                <?= $form->field($model, 'message')->textarea(); ?>
                            </div>
                        <div class="d-flex justify-content-center">
                            <?= $form->field($model, 'recaptcha')->widget(Captcha::className(),
                                [
                                    'template' => '<div class="row"><div class="col-lg-4">{image}</div><div class="col-lg-8">{input}</div></div>',
                                    'captchaAction' => 'site/captcha',
                                    'options' => ['autocomplete' => 'off', 'placeholder' => 'Rasmdagi kodni kiriting', 'class' => 'form-control']
                                ])->label(FALSE) ?>
                        </div>
                            <div class="form-group text-center col-md-12">
                                <?= Html::submitButton(Yii::t('app', 'Arizani yuborish'), ['class'=>'btn btn-theme']) ?>
                            </div>
                            <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--contact end-->
</div>

<!--body content end-->
