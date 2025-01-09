<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\UserAction $model */

$this->title = Yii::t('app', 'Create User Workify');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'User Workifies'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-workify-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
