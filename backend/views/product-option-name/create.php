<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\ProductOptionName $model */

$this->title = Yii::t('app', 'Create Product Option Name');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Product Option Names'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="headline border-0">
    <h2><?= Html::encode($this->title) ?></h2>
</div>

<div class="content with-padding padding-bottom-0 market_create-form">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
