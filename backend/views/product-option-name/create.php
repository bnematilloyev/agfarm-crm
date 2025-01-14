<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\ProductOptionName $model */

$this->title = Yii::t('app', 'Create Product Option Name');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Product Option Names'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-option-name-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
