<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\AdminWorkSchedule $model */

$this->title = 'Jadval Yaratish';
$this->params['breadcrumbs'][] = ['label' => 'Admin Work Schedules', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="admin-work-schedule-create">
    <br>
    <h1><?= Html::encode($this->title) ?></h1>
    <br>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
