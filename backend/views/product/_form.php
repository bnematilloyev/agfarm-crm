<?php

use kartik\select2\Select2;
use common\models\Company;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\widgets\cropper\CropperWidget;
use dosamigos\fileupload\FileUploadUI;
use unclead\multipleinput\MultipleInput;
use unclead\multipleinput\renderers\ListRenderer;
use yii\web\JsExpression;
use yii\helpers\Url;
use common\models\constants\UserRole;

/** @var yii\web\View $this */
/** @var common\models\Product $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="content with-padding padding-bottom-0 comment-content p-0">
    <div style="width:85%; margin: 5px auto;">
        <div class="tabs customer_tabs">
            <div class="tabs-header" style="max-width: 100% !important; width: 100%;">
                <ul class="d-flex align-items-center justify-content-center">
                    <li>
                        <a class="tab__link active" href="javascript:void(0)" data-tab-id="1">
                            <i class="icon-line-awesome-edit"></i> <?= Yii::t('app', 'Main') ?>
                        </a>
                    </li>
                    <li>
                        <a class="tab__link" href="javascript:void(0)" data-tab-id="2">
                            <i class="icon-feather-message-square"></i> <?= Yii::t('app', 'Description') ?>
                        </a>
                    </li>
                    <li>
                        <a class="tab__link" href="javascript:void(0)" data-tab-id="3">
                            <i class="icon-material-outline-dashboard"></i> <?= Yii::t('app', 'Category') ?>
                        </a>
                    </li>
                    <li>
                        <a class="tab__link" href="javascript:void(0)" data-tab-id="4">
                            <i class="icon-line-awesome-dollar"></i> <?= Yii::t('app', 'Price') ?>
                        </a>
                    </li>
                    <li>
                        <a class="tab__link" href="javascript:void(0)" data-tab-id="5">
                            <i class="icon-feather-box"></i> <?= Yii::t('app', 'Image') ?>
                        </a>
                    </li>
                    <li>
                        <a class="tab__link" href="javascript:void(0)" data-tab-id="6">
                            <i class="icon-feather-box"></i> <?= Yii::t('app', 'Video') ?>
                        </a>
                    </li>
                    <li>
                        <a class="tab__link" href="javascript:void(0)" data-tab-id="7">
                            <i class="icon-line-awesome-credit-card"></i> <?= Yii::t('app', 'Similar Products') ?>
                        </a>
                    </li>
                    <?php if ($model->id) { ?>
                    <li>
                        <a class="tab__link" href="javascript:void(0)" data-tab-id="8">
                            <i class="icon-material-outline-assignment"></i> <?= Yii::t('app', 'Meta Data') ?>
                        </a>
                    </li>
                    <?php } ?>
                </ul>
            </div>
            <div class="tabs-content" style="background-color: transparent !important;">
                <?php $form = ActiveForm::begin(); ?>
                <div class="tab  p-0 active" data-tab-id="1">
                    <div class="content p-0">
                        <div class="row">
                            <div class="col-md-12">
                                <?php
                                if (!$model->isNewRecord && Yii::$app->user->identity->is_admin){
                                    echo $form->field($model, 'company_id')->widget(Select2::classname(), [
                                        'data' => ArrayHelper::map(Company::findActive()->all(), 'id', 'name'),
                                        'language' => 'en',
                                        'options' => ['placeholder' => Yii::t('app', 'Select ...')],
                                        'pluginOptions' => [
                                            'allowClear' => true
                                        ]
                                    ]);
                                }
                                ?>
                            </div>
                            <div class="col-md-6">
                                <?= $form->field($model, 'category_id')->widget(Select2::classname(), [
                                    'data' => ArrayHelper::map(\common\models\ProductCategory::findActive()->all(), 'id', 'name_'.Yii::$app->language),
                                    'language' => 'en',
                                    'options' => ['placeholder' => Yii::t('app', 'Select ...')],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ]
                                ]); ?>
                            </div>
                            <div class="col-md-6">
                                <?= $form->field($model, 'brand_id')->widget(Select2::classname(), [
                                    'data' => ArrayHelper::map(\common\models\ProductBrand::findActive()->all(), 'id', 'name_'.Yii::$app->language),
                                    'language' => 'en',
                                    'options' => ['placeholder' => Yii::t('app', 'Select ...')],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ]
                                ]); ?>
                            </div>
                            <div class="col-md-4">
                                <?= $form->field($model, 'name_uz')->textInput(['maxlength' => true]) ?>
                            </div>
                            <div class="col-md-4">
                                <?= $form->field($model, 'name_ru')->textInput(['maxlength' => true]) ?>
                            </div>
                            <div class="col-md-4">
                                <?= $form->field($model, 'name_en')->textInput(['maxlength' => true]) ?>
                            </div>
                            <div class="col-md-4">
                                <?= $form->field($model, 'state')->dropDownList(\common\models\constants\ProductState::getList()) ?>
                            </div>
                            <div class="col-md-4">
                                <?= $form->field($model, 'status')->dropDownList(\common\models\constants\ProductStatus::getList(),['value' => \common\models\constants\ProductStatus::STATUS_ARCHIVED]) ?>
                            </div>
                            <div class="col-md-4">
                                <?= $form->field($model, 'sort')->textInput(['type' => 'number', 'disabled' => true]) ?>
                            </div>
                        </div>

                        <?php if ($model->id) echo $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>

                        <?php if ($model->id){
                            echo $form->field($model, 'creator_id')->dropDownList(\common\models\User::find()->select(['full_name', 'id'])->indexBy('id')->column());
                        } ?>

                        <?php if ($model->id){
                            echo $form->field($model, 'updater_admin_id')->dropDownList(\common\models\User::find()->select(['full_name', 'id'])->indexBy('id')->column());
                        } ?>

                    </div>
                </div>
                <div class="tab  p-0 " data-tab-id="2">
                    <div class="row">
                        <div class="col-md-4">
                            <?= $form->field($model, 'description_uz')->widget(\common\components\ckeditor\CKEditor::className(), [
                                'editorOptions' => [
                                    'preset' => 'full', //разработанны стандартные настройки basic, standard, full данную возможность не обязательно использовать
                                    'inline' => false, //по умолчанию false
                                    'allowedContent' => true,
                                    'extraAllowedContent' => true,
                                    'extraPlugins' => ['pastefromword', 'pastefromgdocs', 'pastetools'],
                                    'forcePasteAsPlainText' => false,
                                ],
                            ]); ?>
                        </div>
                        <div class="col-md-4">
                            <?= $form->field($model, 'description_ru')->widget(\common\components\ckeditor\CKEditor::className(), [
                                'editorOptions' => [
                                    'preset' => 'full', //разработанны стандартные настройки basic, standard, full данную возможность не обязательно использовать
                                    'inline' => false, //по умолчанию false
                                    'allowedContent' => true,
                                    'extraAllowedContent' => true,
                                    'extraPlugins' => ['pastefromword', 'pastefromgdocs', 'pastetools'],
                                    'forcePasteAsPlainText' => false,
                                ],
                            ]); ?>
                        </div>
                        <div class="col-md-4">
                            <?= $form->field($model, 'description_en')->widget(\common\components\ckeditor\CKEditor::className(), [
                                'editorOptions' => [
                                    'preset' => 'full', //разработанны стандартные настройки basic, standard, full данную возможность не обязательно использовать
                                    'inline' => false, //по умолчанию false
                                    'allowedContent' => true,
                                    'extraAllowedContent' => true,
                                    'extraPlugins' => ['pastefromword', 'pastefromgdocs', 'pastetools'],
                                    'forcePasteAsPlainText' => false,
                                ],
                            ]); ?>
                        </div>
                    </div>
                </div>
                <div class="tab  p-0 " data-tab-id="3">
                    <?= $form->field($model, 'categories')->widget(Select2::class, [
                        'data' => ArrayHelper::map(\common\models\ProductCategory::find()->all(), 'id', 'name_'.Yii::$app->language),
                        'options' => [
                            'placeholder' => Yii::t('app', 'Выберите ...'),
                            'multiple' => true
                        ],
                    ]); ?>
                </div>
                <div class="tab  p-0" data-tab-id="4">
                    <?= $form->field($model, 'actual_price')->textInput(['type' => 'number']) ?>

                    <?= $form->field($model, 'cost')->textInput(['type' => 'number']) ?>

                    <?= $form->field($model, 'currency_id')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(\common\models\CurrencyType::find()->orderBy('id')->all(), 'id', 'name'),
                        'language' => 'en',
                        'options' => ['placeholder' => Yii::t('app', 'Select ...')],
                        'pluginOptions' => [
                            'allowClear' => true
                        ]
                    ]); ?>

<!--                    --><?php //= $form->field($model, 'trust_percent')->textInput(['type' => 'number']) ?>
                </div>
                <div class="tab  p-0" data-tab-id="5">
                    <?php echo $form->field($model, 'main_image')->widget(CropperWidget::className(), [
                        'uploadUrl' => \yii\helpers\Url::toRoute('/product/upload-photo'),
                        'prefixUrl' => Yii::getAlias('@assets_url/product/main_image/desktop'),
                        'width' => 1080,
                        'height' => 1080
                    ]) ?>

                    <?= $form->field($model, 'imageField')->widget(FileUploadUI::className(), [
                        'url' => ['media/upload'],
                        'gallery' => true,
                        'fieldOptions' => [
                            'accept' => 'image/*'
                        ],
                        'options' => [
                            'style' => [
                                'height' => '100%'
                            ]
                        ],
                        'downloadTemplateView' => '@app/views/layouts/download_template_image',
                        'clientOptions' => [
                            'maxFileSize' => 3000000,
                            'disableExif' => true,
                        ],
                        'clientEvents' => [
                            'fileuploaddone' => 'function(e, data) {
                                                    console.log(e);
                                                    console.log(data);
                                                }',
                            'fileuploadfail' => 'function(e, data) {
                                                    console.log(e);
                                                    console.log(data);
                                                }',
                        ],
                    ]) ?>
                </div>
                <div class="tab  p-0" data-tab-id="6">
                    <div class="form-group">
                        <?= $form->field($model, 'video')->widget(MultipleInput::className(), [
                            'iconSource' => MultipleInput::ICONS_SOURCE_FONTAWESOME,
                            'min' => 0,
                            'allowEmptyList' => true,
                            'rendererClass' => ListRenderer::className(),
                            'layoutConfig' => [
                                'offsetClass' => 'col-md-offset-0',
                                'labelClass' => 'col-md-4',
                                'wrapperClass' => 'col-md-12',
                                'errorClass' => 'col-md-offset-2 col-md-6',
                                'buttonActionClass' => 'col-md-offset-1 col-md-2',
                            ],
                            'columns' => [
                                [
                                    'name' => 'link',
                                    'title' => Yii::t('app', 'Ссылка видео'),
                                ],
                                [
                                    'name' => 'thumbnail',
                                    'title' => Yii::t('app', 'Ссылка фото'),
                                ],
                            ],
                        ]); ?>
                    </div>
                </div>
                <div class="tab  p-0" data-tab-id="7">
                    <?= $form->field($model, 'similar')->widget(MultipleInput::className(), [
                        'iconSource' => MultipleInput::ICONS_SOURCE_FONTAWESOME,
                        'min' => 1,
                        'allowEmptyList' => true,
                        'rendererClass' => ListRenderer::className(),
                        'layoutConfig' => [
                            'offsetClass' => 'col-md-offset-0',
                            'labelClass' => 'col-md-4',
                            'wrapperClass' => 'col-md-12',
                            'errorClass' => 'col-md-offset-2 col-md-6',
                            'buttonActionClass' => 'col-md-offset-1 col-md-2',
                        ],
                        'columns' => [
                            [
                                'name' => 'product_id',
                                'title' => false,
                                'type' => Select2::className(),
                                'options' => [
                                    'theme' => Select2::THEME_BOOTSTRAP,
                                    'language' => Yii::$app->language,
                                    'data' => $model->getProductIds(),
                                    'pluginOptions' => [
                                        'placeholder' => 'Tanlang',
                                        'allowClear' => true,
                                        'minimumInputLength' => 3,
                                        'language' => [
                                            'errorLoading' => new JsExpression("function () { return '" . Yii::t('app', 'Ждите...') . "'; }"),
                                        ],
                                        'ajax' => [
                                            'url' => Url::to(['product/list', 'status' => true]),
                                            'dataType' => 'json',
                                            'data' => new JsExpression('function(params) { return {q:params.term}; }')
                                        ],
                                        'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                                        'templateResult' => new JsExpression('function(product) { return product.text; }'),
                                        'templateSelection' => new JsExpression('function (product) { return (product.text.length > 80) ? (product.text.substr(0, 80) + "...") : product.text; }'),
                                    ],
                                ]
                            ],
                        ],
                    ]); ?>
                </div>
                <div class="tab  p-0" data-tab-id="8">
                    <div class="row">
                        <div class="col-md-4">
                            <?= $form->field($model, 'meta_json_uz')->textarea() ?>
                        </div>
                        <div class="col-md-4">
                            <?= $form->field($model, 'meta_json_ru')->textarea() ?>
                        </div>
                        <div class="col-md-4">
                            <?= $form->field($model, 'meta_json_en')->textarea() ?>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
