<?php

use common\models\constants\UserRole;
use common\models\constants\UserStatus;
use common\models\Market;
use common\models\User;
use common\widgets\PageSize;
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
<div class="headline border-0">
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <h2><?= Html::encode($this->title) ?></h2>
        <div class="block__w mmt">
            <?= Html::a(Yii::t('app', 'Onlaynlar'), ['index', 'is_online' => true], ['class' => 'button ripple-effect yellow', 'style' => 'padding:7px 30px ; color:white']) ?>
            <?= Html::a(Yii::t('app', 'Create User'), ['create'], ['class' => 'button ripple-effect green', 'style' => 'padding:7px 30px ; color:white; background-color:#00BFAF']) ?>
        </div>
    </div>
</div>

<div class="content with-padding padding-bottom-0 users-table">
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
                'full_name',
                'phone',
                [
                    'attribute' => 'role',
                    'value' => function ($model) {
                        return UserRole::getString($model->role);
                    },
                    'filter' => UserRole::getList()
                ],
                [
                    'attribute' => 'market_id',
                    'value' => function ($model) {
                        return $model->market->name;
                    },
                    'filter' => Yii::$app->user->identity->is_admin ? ArrayHelper::map(Market::findActive()->all(), 'id', 'name') : false,
                ],
                [
                    'attribute' => 'status',
                    'value' => function ($model) {
                        /** @var User $model */
                        return $model->statusName;
                    },
                    'filter' => UserStatus::getList()
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => Yii::$app->user->identity->is_creator ? "{view} {update} {delete} " : (Yii::$app->user->identity->is_admin ? "{view} {update}" : "{view}"),
                    'buttons' => [
                        'view' => function ($url, $model, $key) {
                            return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                                'title' => Yii::t('yii', 'View'),
                                'class' => 'button_view',
                            ]);
                        },
                        'update' => function ($url, $model, $key) {
                            return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                                'title' => Yii::t('yii', 'Update'),
                                'class'     => 'button_update',
                            ]);
                        },
                        'delete' => function ($url, $model, $key) {
                            return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
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
</div>