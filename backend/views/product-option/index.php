<?php

use common\models\ProductOptionName;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\widgets\PageSize;
use kartik\select2\Select2;

/** @var yii\web\View $this */
/** @var backend\models\search\ProductOptionSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Product Options');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="headline border-0 ">
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <h2><?= Html::encode($this->title) ?></h2>
        <div class="block__w mmt">
            <?= Html::a(Yii::t('app', 'Create option'), ['create'], ['class' => 'd-inline button ripple-effect green', 'style' => 'padding:7px 30px; background-color:#00BFAF']) ?>
        </div>
    </div>
</div>

<div class="content with-padding padding-bottom-0 markent-content">
    <?php Pjax::begin(); ?>
    <?= PageSize::widget(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'product_id',
                'value' => function ($model) {
                    return $model->product->{'name_' . Yii::$app->language};
                },
                'filter' => Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'product_id',
                    'data' => \yii\helpers\ArrayHelper::map(\common\models\Product::findActive()->all(), 'id', 'name_'.Yii::$app->language),
                    'theme' => Select2::THEME_BOOTSTRAP,
                    'options' => [
                        'placeholder' => Yii::t('app', 'Select ...'),
                    ],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]),
                'format' => 'raw',
            ],
            [
                'attribute' => 'option_name',
                'value' => function ($model) {
                    return $model->optionName->{'name_' . Yii::$app->language};
                },
                'filter' => Select2::widget([
                        'model' => $searchModel,
                        'attribute' => 'option_name',
                        'data' => \yii\helpers\ArrayHelper::map(ProductOptionName::findActive()->all(), 'id', 'name_'.Yii::$app->language),
                        'theme' => Select2::THEME_BOOTSTRAP,
                        'options' => [
                            'placeholder' => Yii::t('app', 'Select ...'),
                        ],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]),
                'format' => 'raw',
            ],
            'value',
            [
                'attribute' => 'option_type',
                'value' => function ($model) {
                    return $model->optionType->{'name_' . Yii::$app->language};
                },
                'filter' => Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'option_type',
                    'data' => \yii\helpers\ArrayHelper::map(\common\models\ProductOptionType::findActive()->all(),'id','name_'.Yii::$app->language),
                    'theme' => Select2::THEME_BOOTSTRAP,
                    'options' => [
                        'placeholder' => Yii::t('app', 'Select ...'),
                    ],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]),
                'format' => 'raw',
            ],
            [
                'attribute' => 'status',
                'value' => function ($model) {
                    /** @var \common\models\ProductOption $model */
                    return '<div class="status_option_' . $model->status . '">' . $model->statusName . '</div>';
                },
                'format' => 'raw',

                'filter' => \common\models\constants\GeneralStatus::getList()
            ],
            [
                'attribute' => 'created_at',
                'value' => function ($model) {
                    return date('M d, Y H:i:s', $model->created_at);
                },
                'filter' => \dosamigos\datepicker\DateRangePicker::widget([
                    'model' => $searchModel,
                    'attributeTo' => 'to_date_range',
                    'attribute' => 'from_date_range',
                    'labelTo' => '-',
                    'value' => $searchModel->from_date_range,
                    'valueTo' => $searchModel->to_date_range,
                    'clientOptions' => [
                        'format' => 'dd-mm-yyyy',
                        'autoclose' => true
                    ]
                ]),
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => Yii::$app->user->identity->is_creator ? "{view} {update} {delete} " : (Yii::$app->user->identity->is_admin ? "{view} {update}" : "{view}"),
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        return \yii\helpers\Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                            'title' => Yii::t('yii', 'View'),
                            'class' => 'button_view',
                        ]);
                    },
                    'update' => function ($url, $model, $key) {
                        return \yii\helpers\Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                            'title' => Yii::t('yii', 'Update'),
                            'class' => 'button_update',
                        ]);
                    },
                    'delete' => function ($url, $model, $key) {
                        return \yii\helpers\Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                            'title' => Yii::t('yii', 'Delete'),
                            'class' => 'button_delete',
                            'data' => [
                                'confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                'method' => 'post',
                            ],
                        ]);
                    },
                ],
                'contentOptions' => [
                    'class' => 'buttons_update-icon',
                ],
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
