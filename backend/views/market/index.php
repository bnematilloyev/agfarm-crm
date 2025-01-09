<?php

use common\models\Company;
use common\models\constants\GeneralStatus;
use common\models\Market;
use common\widgets\PageSize;
use dosamigos\datepicker\DateRangePicker;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\MarketSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', ' Markets');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="headline border-0 ">
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <h2><?= Html::encode($this->title) ?></h2>
        <div class="block__w mmt">
            <?= Html::a(Yii::t('app', 'Create Market'), ['create'], ['class' => 'd-inline button ripple-effect green', 'style' => 'padding:7px 30px; background-color:#00BFAF']) ?>
        </div>
    </div>
</div>

<div class="content with-padding padding-bottom-0 markent-content">
    <?php Pjax::begin(); ?>
    <?= PageSize::widget(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <div class="custom__table" style="overflow-x: auto;overflow-y: hidden;">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'filterSelector' => 'select[name="per-page"]',
            'pager' => array(
                'maxButtonCount' => 5,
                'firstPageLabel' => '<i class="icon-material-outline-keyboard-arrow-left"></i>',
                'lastPageLabel' => '<i class="icon-material-outline-keyboard-arrow-right"></i>'
            ),
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'attribute' => 'company_id',
                    'value' => function ($model) {
                        /** @var Market $model */
                        return $model->company->name;
                    },
                    'filter' => Yii::$app->user->identity->is_creator ? Select2::widget([
                        'model' => $searchModel,
                        'attribute' => 'company_id',
                        'data' => ArrayHelper::map(Company::findActive()->all(), 'id', 'name'),
                        'theme' => Select2::THEME_BOOTSTRAP,
                        'options' => [
                            'placeholder' => Yii::t('app', 'Select ...'),
                        ],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]) : false
                ],
                [
                    'attribute' => 'name',
                    'contentOptions' => ['style' => 'color: #008DFF; font-weight: bold;'],
                ],
                [
                    'attribute' => 'status',
                    'value' => function ($model) {
                        /** @var \common\models\Market $model */
                        return '<div class="status_market_' . $model->status . '">' . $model->statusName . '</div>';
                    },
                    'format' => 'raw',

                    'filter' => GeneralStatus::getList()
                ],
                [
                    'attribute' => 'created_at',
                    'value' => function ($model) {
                        return date('M d, Y H:i:s', $model->created_at);
                    },
                    'filter' => DateRangePicker::widget([
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
    </div>
    <?php Pjax::end(); ?>

</div>