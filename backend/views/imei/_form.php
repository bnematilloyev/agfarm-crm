<?php

use common\models\Customer;
use common\models\Product;
use dosamigos\datepicker\DatePicker;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Imei $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="imei-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'buyer_id')->widget(Select2::classname(), [
                'data' => ArrayHelper::map(Customer::find()->all(), 'id', 'full_name'),
                'language' => 'en',
                'options' => ['placeholder' => Yii::t('app', 'Select ...')],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]) ?>
            <?= $form->field($model, 'imei2')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'imei1')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'product_id')->widget(Select2::classname(), [
                'data' => ArrayHelper::map(Product::find()->all(), 'id', 'name_uz'),
                'language' => 'en',
                'options' => ['placeholder' => Yii::t('app', 'Select ...')],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]) ?>
            <?= $form->field($model, 'expires_in')->widget(DatePicker::className(), [
                'clientOptions' => [
                    'autoclose' => true,
                    'format' => 'dd.mm.yyyy',
                ],
                'options' => ['autocomplete' => 'off']
            ]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
