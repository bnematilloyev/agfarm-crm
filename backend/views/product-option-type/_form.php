<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\ProductOptionType $model */
/** @var yii\widgets\ActiveForm $form */
?>

<?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'name_uz')->textInput(['maxlength' => true, 'class' => 'with-border']) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'name_ru')->textInput(['maxlength' => true, 'class' => 'with-border']) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'name_en')->textInput(['maxlength' => true, 'class' => 'with-border']) ?>
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

