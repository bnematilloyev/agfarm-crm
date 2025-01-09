<?php

use yii\bootstrap4\Html;
use common\models\Company;
use common\models\constants\GeneralStatus;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Market */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin(); ?>
<div class="row">
    <div class="col-md-6">
        <?php if (Yii::$app->user->identity->is_creator){
            echo $form->field($model, 'company_id')->widget(Select2::classname(), [
                'data' => ArrayHelper::map(Company::findActive()->all(), 'id', 'name'),
                'language' => 'en',
                'options' => ['placeholder' => Yii::t('app', 'Select ...')],
                'pluginOptions' => [
                    'allowClear' => true
                ]
            ]);
            }else{
                echo Html::label(Yii::t('app', 'Company'));
                echo Html::textInput('company_id',$model->company->name ?? "Belgilanmagan", ['class' => 'with-border', 'disabled' => true]);
            }
        ?>
    </div>

    <div class="col-md-6">
        <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'class' => 'with-border']) ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($model, 'address')->textInput(['maxlength' => true, 'class' => 'with-border']) ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($model, 'status')->dropDownList(GeneralStatus::getList()) ?>
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