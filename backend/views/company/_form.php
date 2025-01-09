<?php

use common\models\constants\GeneralStatus;
use common\models\Region;
use dosamigos\datepicker\DatePicker;
use kartik\depdrop\DepDrop;
use sultonov\cropper\CropperWidget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Company */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin(); ?>
<div class="row">
    <div class="col-md-3">
        <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'class' => 'with-border']) ?>
    </div>
    <div class="col-md-3">
        <?= $form->field($model, 'phone')->textInput(['maxlength' => true, 'class' => 'with-border']) ?>
    </div>
    <div class="col-md-3">
        <?= $form->field($model, 'status')->dropDownList(GeneralStatus::getList()) ?>
    </div>
    <div class="col-md-4">
        <?= $form->field($model, 'address')->textInput(['class' => 'with-border']) ?>
    </div>
    <div class="col-md-12">
        <div class="d-flex justify-content-center align-items-center mt-20" style="gap: 20px">
            <a class="d-block cursor-pointer"
               style="padding: 4px 30px ; color: silver ;border: 1px solid silver ; border-radius:4px ;background-color: transparent"
               href="/"> Bekor qilish</a>
            <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'button ripple-effect ', 'style' => 'padding:8px 30px; background-color:#00BFAF']) ?>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>

