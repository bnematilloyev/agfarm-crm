<?php

use common\models\User;
use common\models\UserAction;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var backend\models\search\UserActionSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'User Actions');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="headline border-0">
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <h2><?= Html::encode($this->title) ?></h2>
    </div>
</div>
<div class="content with-padding padding-bottom-0 sms-content-table">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'user_id',
                'value' => function ($model) {
                    /** @var UserAction $model */
                    return $model->user->full_name;
                },
                'filter' => Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'user_id',
                    'data' => ArrayHelper::map(User::findActive()->all(), 'id', 'full_name'),
                    'options' => ['placeholder' => 'Select...'],
                ])
            ],
            [
                'attribute' => 'photo',
                'format' => 'raw',
                'value' => function ($model) {
                    /** @var UserAction $model */
                    return '<a href="' . $model->photo . '"data-fancybox="images" data-caption="' . $model->user->full_name . '"><img src="' . $model->photo . '" style="width: 150px" class="pull-right"></a>';
                },
                'filter' => false
            ],
            'lat',
            'long',
            'created_at:datetime',
            [
                'class' => ActionColumn::className(),
                'template' => '{view}',
            ],
        ],
    ]); ?>


</div>
