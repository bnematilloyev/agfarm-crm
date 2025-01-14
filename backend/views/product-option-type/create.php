<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\ProductOptionType $model */

$this->title = Yii::t('app', 'Create Product Option Type');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Product Option Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-option-type-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
