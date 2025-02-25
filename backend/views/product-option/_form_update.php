<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use common\models\ProductOptionName;


/** @var yii\web\View $this */
/** @var common\models\ProductOption $model */
/** @var yii\widgets\ActiveForm $form */
?>

<?php $form = ActiveForm::begin(); ?>
<div class="row">
    <div class="col-md-4">
        <?= $form->field($model, 'option_name')->widget(\kartik\select2\Select2::classname(), [
            'data' => ArrayHelper::map(ProductOptionName::findActive()->all(), 'id', 'name_'.Yii::$app->language),
            'language' => 'en',
            'options' => ['placeholder' => Yii::t('app', 'Select ...')],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]); ?>
    </div>
    <div class="col-md-4">
        <?= $form->field($model, 'value')->textInput(['maxlength' => true, 'class' => 'with-border']) ?>
    </div>
    <div class="col-md-4">
        <?= $form->field($model, 'option_type')->widget(\kartik\select2\Select2::classname(), [
            'data' => ArrayHelper::map(\common\models\ProductOptionType::findActive()->all(), 'id', 'name_'.Yii::$app->language),
            'language' => 'en',
            'options' => ['placeholder' => Yii::t('app', 'Select ...')],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]); ?>
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
