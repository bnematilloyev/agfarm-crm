<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\ProductOptionType $model */

$this->title = Yii::t('app', 'Update Product Option Type: {name}', [
    'name' => $model->{'name_' . Yii::$app->language},
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Product Option Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->{'name_' . Yii::$app->language}, 'url' => ['view', 'id' => $model->id]];
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
