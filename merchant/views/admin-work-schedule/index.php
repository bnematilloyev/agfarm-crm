<?php

use common\models\AdminWorkSchedule;
use common\models\constants\WeekDay;
use common\models\User;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var backend\models\search\AdminWorkScheduleSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Admin Work Schedules';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="headline">
    <div class="d-flex justify-content-between align-items-center">
        <h2><?= Html::encode($this->title) ?></h2>
        <div>
            <?= Html::a('Create Schedule', ['create'], ['class' => 'btn btn-success']) ?>
        </div>
    </div>
</div>

<div class="content with-padding padding-bottom-0">

<!--    --><?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'admin_id',
                'value' => function ($model) {
                    /** @var AdminWorkSchedule $model */
                    return Html::a($model->admin->full_name);
                },
                'format' => 'raw',
                'filter' => Yii::$app->user->identity->is_admin ? Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'admin_id',
                    'data' => ArrayHelper::map(User::findActive()->all(), 'id', 'full_name'),
                    'theme' => Select2::THEME_BOOTSTRAP,
                    'options' => [
                        'placeholder' => Yii::t('app', 'Select ...'),
                    ],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]) : false
            ],
            'start:datetime',
            'finish:datetime',
            [
                'attribute' => 'weekday',
                'value' => function ($model) {
                    /** @var AdminWorkSchedule $model */
                    return Html::a(WeekDay::getString($model->weekday), ['calendar', 'user_id' => $model->admin_id]);
                },
                'format' => 'raw'
            ],
            [
                'class' => ActionColumn::className(),
                'template' => Yii::$app->user->identity->is_developer ? "{view}{update}{delete}" : "{view}"
            ],
        ],
    ]); ?>


</div>
