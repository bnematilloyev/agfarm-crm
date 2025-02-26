<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\ProductBrand $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="product-brand-form">

    <?php $form = ActiveForm::begin(); ?>
        <div class="product-brand-create content with-padding padding-bottom-0 comment-update form-create-update mb-20">
            <div class="row">
                <div class="col-md-6">
                    <h3 class="mb-10"><?=Yii::t('app', 'Main')?></h3>
                    <?= $form->field($model, 'name_uz')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'name_ru')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'name_en')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'official_link')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($model, 'image')->widget(\sultonov\cropper\CropperWidget::className(), [
                                'uploadUrl' => Url::toRoute('/product-brand/upload-photo'),
                                'prefixUrl' => Yii::getAlias('@assets_url/brand/image/'),
                                'width' => 225,
                                'height' => 225
                            ]) ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'wallpaper')->widget(\sultonov\cropper\CropperWidget::className(), [
                                'uploadUrl' => Url::toRoute('/product-brand/upload-wallpaper'),
                                'prefixUrl' => Yii::getAlias('@assets_url/brand/wallpaper/'),
                                'width' => 2000,
                                'height' => 700
                            ]) ?>
                        </div>
                    </div>
                    <?= $form->field($model, 'status')->dropDownList(\common\models\constants\GeneralStatus::getList()) ?>
                    <?= $form->field($model, 'home_page')->checkbox() ?>
                </div>
            </div>
        </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="product-brand-create content with-padding padding-bottom-0 comment-update form-create-update mb-20">
                        <h3 class="mb-10"><?=Yii::t('app', 'Description')?></h3>
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
                </div>
                <?php if ($model->id) { ?>
                    <div class="col-md-12">
                        <div class="product-brand-create content with-padding padding-bottom-0 comment-update form-create-update mb-20">
                            <h3 class="mb-10"><?=Yii::t('app', 'Meta Data')?></h3>
                            <?= $form->field($model, 'meta_json_uz')->textInput() ?>
                            <?= $form->field($model, 'meta_json_ru')->textInput() ?>
                            <?= $form->field($model, 'meta_json_en')->textInput() ?>
                        </div>
                    </div>
                <?php } ?>
            </div>

        <div class="col-md-12">
            <div class="d-flex justify-content-center align-items-center mt-20" style="gap: 20px">
                <?= Html::a(Yii::t('app', 'Bekor qilish'),Url::to(['/product-brand/index']) ,['class' => 'd-block cursor-pointer', 'style' => 'padding: 4px 30px ; color: silver ;border: 1px solid silver ; border-radius:4px ;background-color: transparent'])?>
                <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'button ripple-effect ', 'style' => 'padding:8px 30px; background-color:#00BFAF']) ?>
            </div>
        </div>

    <?php ActiveForm::end(); ?>

</div>
