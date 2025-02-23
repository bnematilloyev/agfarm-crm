<?php

use kartik\select2\Select2;
use yii\web\JsExpression;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\ProductOption $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="product-option-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'product_id')->widget(Select2::classname(), [
                'data' => \yii\helpers\ArrayHelper::map(\common\models\Product::findActive()->all(), 'id', 'name_'.Yii::$app->language),
                'language' => 'en',
                'options' => ['placeholder' => Yii::t('app', 'Select ...')],
                'pluginOptions' => [
                    'allowClear' => true
                ]
            ]); ?>
        </div>
        <div class="col-md-9">
            <?= $form->field($model, 'options')->widget(\unclead\multipleinput\MultipleInput::className(), [
                'iconSource' => \unclead\multipleinput\MultipleInput::ICONS_SOURCE_FONTAWESOME,
                'min' => 1,
                'allowEmptyList' => true,
                'rendererClass' => \unclead\multipleinput\renderers\ListRenderer::className(),
                'layoutConfig' => [
                    'class' => 'd-flex flex-row align-items-center gap-3',
                    'labelClass' => 'col-md-4',
                    'wrapperClass' => 'col-md-4',
                    'errorClass' => 'col-md-6',
                    'buttonActionClass' => 'col-md-2',
                ],
                'columns' => [
                    [
                        'name' => 'option_name',
                        'type' => Select2::className(),
                        'options' => [
                            'theme' => Select2::THEME_BOOTSTRAP,
                            'language' => Yii::$app->language,
                            'data' => \yii\helpers\ArrayHelper::map(\common\models\ProductOptionName::findActive()->all(), 'id', 'name_'.Yii::$app->language),
                            'pluginOptions' => [
                                'placeholder' => Yii::t('app', 'Select ...'),
                                'allowClear' => true,
                            ],
                        ]
                    ],
                    [
                        'name' => 'value',
                        'type' => 'textInput',
                        'options' => [
                            'maxlength' => true,
                        ]
                    ],
                    [
                        'name' => 'option_type',
                        'type' => Select2::className(),
                        'options' => [
                            'theme' => Select2::THEME_BOOTSTRAP,
                            'language' => Yii::$app->language,
                            'data' => \yii\helpers\ArrayHelper::map(\common\models\ProductOptionType::findActive()->all(),'id','name_'.Yii::$app->language),
                            'pluginOptions' => [
                                'placeholder' => Yii::t('app', 'Select ...'),
                                'allowClear' => true,
                            ],
                        ]
                    ],
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

</div>
