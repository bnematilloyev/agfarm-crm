<?php

use common\models\constants\UserStatus;
use common\models\User;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;

/** @var yii\web\View $this */
/** @var common\models\AdminWorkSchedule $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="raw">

    <?php $form = ActiveForm::begin(); ?>

    <div class="col-md-6">
        <?= $form->field($model, 'admin_id')->widget(Select2::classname(), [
            'data' => ArrayHelper::map(User::findActive()->andWhere(['status' => UserStatus::STATUS_ACTIVE])->all(), 'id', 'full_name'),
            'language' => 'en',
            'options' => ['placeholder' => Yii::t('app', 'Select ...')],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]) ?>
    </div>


    <div class="col-md-6">
        <?= $form->field($model, 'start', [
            'template' => '<div>{label}{input}</div>',
            'options' => ['tag' => false]
        ])->widget(MaskedInput::className(), [
            'mask' => '99:99',
            'options' => [
                'placeholder' => 'hh:mm',
                'class' => 'bg-[#F2F4F7] border border-[#F2F4F7] placeholder-[#B2C0CD] text-base font-normal rounded-lg w-full',
                'onInput' => 'validateTime(this)',
            ],
            'clientOptions' => [
                'greedy' => false
            ]
            ]) ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($model, 'finish', [
            'template' => '<div>{label}{input}</div>',
            'options' => ['tag' => false]
        ])->widget(MaskedInput::className(), [
            'mask' => '99:99',
            'options' => [
                'placeholder' => 'hh:mm',
                'class' => 'bg-[#F2F4F7] border border-[#F2F4F7] placeholder-[#B2C0CD] text-base font-normal rounded-lg w-full',
                'onInput' => 'validateTime(this)',
            ],
            'clientOptions' => [
                'greedy' => false
            ]
        ]) ?>
    </div>

    <div class="col-md-5">
        <?= $form->field($model, 'days[]')->checkboxList([
            '1' => 'Dushanba',
            '2' => 'Seshanba',
            '3' => 'Chorshanba',
            '4' => 'Payshanba',
            '5' => 'Juma',
            '6' => 'Shanba',
            '0' => 'Yakshanba',
        ]); ?>
    </div>

    <div class="form-group left center">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script>
    function validateTime(input) {
        const value = input.value;
        const [hours, minutes] = value.split(':').map(Number);

        let validHours = hours;
        let validMinutes = minutes;

        if (hours > 23) {
            validHours = 23;
        }

        if (minutes > 59) {
            validMinutes = 59;
        }

        if (!isNaN(validHours) && !isNaN(validMinutes)) {
            input.value = (validHours < 10 ? '0' + validHours : validHours) + ':' + (validMinutes < 10 ? '0' + validMinutes : validMinutes);
        }
    }
</script>

