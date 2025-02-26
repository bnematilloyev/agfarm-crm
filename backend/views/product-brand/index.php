<?php

use common\models\ProductBrand;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var backend\models\ProductBrandSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Product Brands');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="headline border-0">
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <div class="d-flex align-items-center">
            <button onclick="customNavigate(-1)" class="go_back mr-10"><img src="/images/icons/go_back.svg"></button>
            <h2><?= Html::encode($this->title) ?></h2>
        </div>
        <div class="block__w mmt">
            <?= Html::a(Yii::t('app', 'Add Product Brand'), ['create'], ['class' => 'btn btn-success']) ?>
        </div>
    </div>
</div>

<div class="content with-padding padding-bottom-0 main-index-tables">
    <?php \yii\widgets\Pjax::begin(); ?>
    <?= \common\widgets\PageSize::widget(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'filterSelector' => 'select[name="per-page"]',
        'pager' => array(
            'maxButtonCount' => 5,
            'firstPageLabel' => '<<<',
            'lastPageLabel' => '>>>'
        ),
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name_uz',
            'name_ru',
            'name_en',
            'slug',
            [
                'attribute' => 'image',
                'format' => 'html',
                'value' => function ($model) {
                    return Html::img(Yii::getAlias('@assets_url/brand/image') . $model->image, ['width' => '200px']);
                },
                'filter' => false,
            ],
            'home_page:boolean',
            'meta_json_uz',
            'meta_json_ru',
            'meta_json_en',
            [
                'attribute' => 'status',
                'value' => function ($model) {
                    return \common\models\constants\GeneralStatus::getString($model->status);
                }
            ],
            [
                'attribute' => 'official_link',
                'format' => 'html',
                'value' => function ($model) {
                    return Html::a($model->official_link, $model->official_link, ['target' => '_blank']);
                }
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
                'template' => Yii::$app->user->identity->is_creator ? "{view} {update} {delete} " : (Yii::$app->user->identity->is_developer ? "{view} {update}" : "{view}"),
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
    <?php \yii\widgets\Pjax::end(); ?>

</div>
