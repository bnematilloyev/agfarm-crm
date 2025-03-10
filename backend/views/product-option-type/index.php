<?php

use common\models\ProductOptionType;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var backend\models\search\ProductOptionTypeSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Product Option Types');
$this->params['breadcrumbs'][] = $this->title;
?>

    <div class="headline border-0 ">
        <div class="d-flex justify-content-between align-items-center flex-wrap">
            <h2><?= Html::encode($this->title) ?></h2>
            <div class="block__w mmt">
                <?= Html::a(Yii::t('app', 'Create option type'), ['create'], ['class' => 'd-inline button ripple-effect green', 'style' => 'padding:7px 30px; background-color:#00BFAF']) ?>
            </div>
        </div>
    </div>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

<div class="content with-padding padding-bottom-0 markent-content">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name_uz',
            'name_ru',
            'name_en',
            [
                'attribute' => 'status',
                'value' => function ($model) {
                    /** @var \common\models\Company $model */
                    return $model->statusName;
                },
                'filter' => \common\models\constants\GeneralStatus::getList()
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
