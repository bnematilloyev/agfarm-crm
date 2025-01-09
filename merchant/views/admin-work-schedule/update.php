<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\AdminWorkSchedule $model */

$this->title = 'Ish jadvalini o`zgartirish: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Admin Work Schedules', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="admin-work-schedule-update">
    <br>
    <h1><?= Html::a($this->title) ?></h1>
    <br>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
