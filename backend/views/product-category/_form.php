<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\ProductCategory $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="product-category-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-6">
            <?php echo $form->field($model, 'image')->widget(\sultonov\cropper\CropperWidget::className(), [
                'uploadUrl' => \yii\helpers\Url::toRoute('/product-category/upload-photo'),
                'prefixUrl' => Yii::getAlias('@assets_url/category/desktop'),
                'width' => 1080,
                'height' => 1080
            ]) ?>

            <?= $form->field($model, 'name_uz')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'name_ru')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'name_en')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'parent_id', ['labelOptions' => ['label' => Yii::t('app', 'Parent ID')]])->widget(kartik\select2\Select2::class, [
                'data' => \yii\helpers\ArrayHelper::map(\common\models\ProductCategory::find()->all(), 'id', 'name'),
                'options' => ['placeholder' => 'Select a section...'],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'description_uz')->textarea(['rows' => 6]) ?>

            <?= $form->field($model, 'description_ru')->textarea(['rows' => 6]) ?>

            <?= $form->field($model, 'description_en')->textarea(['rows' => 6]) ?>
        </div>
        <div class="col-md-12">
            <div class="d-flex justify-content-center align-items-center mt-20" style="gap: 20px">
                <?= Html::a(Yii::t('app', 'Bekor qilish'),Url::to(['/product-category/index']) ,['class' => 'd-block cursor-pointer', 'style' => 'padding: 4px 30px ; color: silver ;border: 1px solid silver ; border-radius:4px ;background-color: transparent'])?>
                <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'button ripple-effect ', 'style' => 'padding:8px 30px; background-color:#00BFAF']) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
