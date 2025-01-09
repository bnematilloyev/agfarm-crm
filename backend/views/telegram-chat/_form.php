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

    <?php if (Yii::$app->user->identity->is_creator) { ?>
        <div class="col-md-4">
            <?= $form->field($model, 'company_id')->widget(\kartik\select2\Select2::classname(), [
                'data' => ArrayHelper::map(Company::findActive()->all(), 'id', 'name'),
                'options' => ['id' => 'marketid', 'placeholder' => Yii::t('app', 'Select ...')],
                'pluginOptions' => [
                    'placeholder' => Yii::t('app', 'Select ...'),
                    'url' => Url::to(['#']),
                    'allowClear' => true
                ]
            ])->label($model->getAttributeLabel('company_id') . '<span style="color: red">*</span>') ?>
        </div>

        <div class="col-md-4">
            <?= $form->field($model, 'market_id')->widget(DepDrop::classname(), [
                'type' => DepDrop::TYPE_SELECT2,
                'data' => $model->market_id != null ? [$model->market_id => Market::findOne($model->market_id)->name] : [],
                'pluginOptions' => [
                    'depends' => ['marketid'],
                    'placeholder' => false,
                    'url' => Url::to(['customer-state/choose-market']),
                    'allowClear' => true
                ]
            ])->label($model->getAttributeLabel('market_id') . '<span style="color: red">*</span>') ?>
        </div>
    <?php } ?>

    <div class="col-md-4">
        <?= $form->field($model, 'chat_id')->textInput(['maxlength' => true, 'class' => 'with-border']) ?>
    </div>

    <div class="col-md-4">
        <?= $form->field($model, 'user_id')->widget(\kartik\select2\Select2::classname(), [
            'data' => ArrayHelper::map(User::findActive()->all(), 'id', 'full_name'),
            'options' => ['placeholder' => Yii::t('app', 'Select ...')],
        ])->label($model->getAttributeLabel('user_id') . '<span style="color: red">*</span>') ?>
    </div>

    <div class="col-md-4">
        <?= $form->field($model, 'slug')->textInput(['maxlength' => true, 'class' => 'with-border']) ?>
    </div>

    <div class="col-md-4">
        <?= $form->field($model, 'status')->dropDownList(GeneralStatus::getList()) ?>
    </div>


    <div class="col-md-12">
        <div class="d-flex justify-content-center align-items-center mt-30">
            <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'button ripple-effect green save_button']) ?>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>
