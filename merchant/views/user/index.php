<?php

use common\widgets\PageSize;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Users');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="headline">
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <h2><?= Html::encode($this->title) ?></h2>
        <div class="block__w mmt">
            <?= Html::a(Yii::t('app', 'Create User'), ['create'], ['class' => 'button ripple-effect green']) ?>
        </div>
    </div>
</div>

<div class="content with-padding padding-bottom-0 user__index-content">

    <?php Pjax::begin(); ?>
    <?= PageSize::widget(); ?>
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
                    'attribute' => 'image',
                    'format' => 'raw',
                    'value' => function (\common\models\User $model) {
                        return '<a href="' . Yii::getAlias("@assets_url/user/") . $model->image . '" data-fancybox="images" data-caption="' . $model->full_name . '">' . Html::img(Yii::getAlias("@assets_url/user/") . $model->image, ['width' => '80px']) . '</a>';
                    }
                ],
                'full_name',
                'phone',
                [
                    'attribute' => 'role',
                    'value' => function ($model) {
                        return \common\models\constants\UserRole::getString($model->role);
                    },
                    'filter' => \common\models\constants\UserRole::getList()
                ],
//                [
//                    'attribute' => 'role',
//                    'format' => 'raw',
//                    'value' => function ($model) {
//                        /** @var \common\models\User $model */
//                        return $model->totals;
//                    },
//                    'filter' => false,
//                    'label' => "Hisobot"
//                ],
                [
                    'attribute' => 'market_id',
                    'value' => function ($model) {
                        return $model->market->name;
                    },
                    'filter' => Yii::$app->user->identity->is_admin ? ArrayHelper::map(\common\models\Market::findActive()->all(), 'id', 'name') : false,
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => Yii::$app->user->identity->is_creator ? "{view} {update} {delete} " : (Yii::$app->user->identity->is_president ? "{view} {update}" : "{view}"),
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
    <?php Pjax::begin(); ?>


</div>
