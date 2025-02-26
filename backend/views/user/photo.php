<?php

use sultonov\cropper\CropperWidget;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = Yii::t('app', "Rasmni o`zgartirish");
/* @var $this yii\web\View */
/* @var $model \backend\models\forms\UserRegisterForm */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-photo">
    <?php $form = ActiveForm::begin(); ?>
    <h1><?=Html::encode($this->title)?> </h1>

    <?php  if ($model->id) echo $form->field($model, 'image')->widget(CropperWidget::className(), [
        'uploadUrl' => Url::toRoute('/user/upload-photo'),
        'prefixUrl' => Yii::getAlias('@assets_url/user/'),
        'avatar' => true,
        'width' => 640,
        'height' => 960
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Saqlash'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
