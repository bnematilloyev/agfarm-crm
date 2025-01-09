<?php

use common\models\Company;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\TelegramBot */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin(); ?>
<div class="row">

    <div class="col-md-4">
        <?php if (Yii::$app->user->identity->is_creator)
            echo $form->field($model, 'company_id')->widget(Select2::classname(), [
                'data' => ArrayHelper::map(Company::findActive()->all(), 'id', 'name'),
                'language' => 'en',
                'options' => ['placeholder' => Yii::t('app', 'Select ...')],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]) ?>
    </div>

        <div class="col-md-4">
        <?= $form->field($model, 'status')->dropDownList(\common\models\constants\GeneralStatus::getList()) ?>
    </div>

    <div class="col-md-4">
        <?= $form->field($model, 'token')->textInput(['maxlength' => true, 'class' => 'with-border']) ?>
    </div>

    <div class="col-md-12">
        <div class="d-flex justify-content-center align-items-center mt-30">
            <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'button ripple-effect green save_button' ]) ?>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>

