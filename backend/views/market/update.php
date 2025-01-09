<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Market */

$this->title = Yii::t('app', 'Update Market: {name}', [
    'name' => $model->name,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Markets'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="headline border-0">
    <h2><?= Html::encode($this->title) ?></h2>
</div>

<div class="content with-padding padding-bottom-0  market_create-form">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
