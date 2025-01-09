<?php

use common\models\Company;
use common\models\constants\GeneralStatus;
use common\models\Market;
use common\models\User;
use kartik\depdrop\DepDrop;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\TelegramChat */
/* @var $form yii\widgets\ActiveForm */
?>


<?php $form = ActiveForm::begin(); ?>

<div class="row">
    <div class="col-md-12">
        <?= $form->field($model, 'custom_text')->textarea(['rows' => 10, 'class' => 'with-border'])->label(Yii::t('app', "Xabar matni")) ?>
    </div>

    <div class="col-md-12">
        <div>
            <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'button ripple-effect green']) ?>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>
