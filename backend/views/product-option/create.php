<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\ProductOption $model */

$this->title = Yii::t('app', 'Create Product Option');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Product Options'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-option-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
