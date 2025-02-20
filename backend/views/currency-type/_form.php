<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\CurrencyType $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="currency-type-form">
    <?php $form = ActiveForm::begin(); ?>
        <div class="row">
            <div class="col-md-4">
                <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'value')->textInput() ?>
            </div>
            <div class="col-md-12">
                <div class="d-flex justify-content-center align-items-center mt-20" style="gap: 20px">
                    <?= Html::a(Yii::t('app', 'Bekor qilish'),Url::to(['/currency-type/index']) ,['class' => 'd-block cursor-pointer', 'style' => 'padding: 4px 30px ; color: silver ;border: 1px solid silver ; border-radius:4px ;background-color: transparent'])?>
                    <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'button ripple-effect ', 'style' => 'padding:8px 30px; background-color:#00BFAF']) ?>
                </div>
            </div>
        </div>
    <?php ActiveForm::end(); ?>
</div>
