<?php

use common\models\AdminWorkSchedule;
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\AdminWorkSchedule $model */

$this->title = $model->admin->full_name;
$this->params['breadcrumbs'][] = ['label' => 'Admin Work Schedules', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="headline">
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <h2><?= Html::encode($this->title) ?></h2>
        <div class="block__w mmt">
            <?php if (Yii::$app->user->identity->is_developer) {
                echo Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']);
                echo Html::a('Delete', ['delete', 'id' => $model->id], [

                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => 'Are you sure you want to delete this item?',
                        'method' => 'post',
                    ],
                ]);
            } ?>
        </div>
    </div>

</div>
<div class="content with-padding padding-bottom-0">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute' => 'admin_id',
                'value' => function ($model) {
                    return $model->admin->full_name;
                }
            ],
            'start:time',
            'finish:time',
            'created_at:date',
            'updated_at:date',
            [
                'attribute' => 'weekDays',
                'value' => function ($model) {
                    /** @var AdminWorkSchedule $model */
                    return Html::a($model->days, ['calendar', 'admin_id' => $model->admin_id]);
                },
                'format' => 'raw'
            ],
        ],
    ]) ?>

</div>
