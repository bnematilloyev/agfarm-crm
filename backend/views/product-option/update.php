<?php

use common\models\ProductOption;
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\ProductOption $model */

$product_option = \common\models\Product::findOne($model->product_id)->{'name_' . Yii::$app->language};

$this->title = Yii::t('app', 'Update Product Option: {name}', [
    'name' => $product_option,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Product Options'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $product_option, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="headline border-0">
    <h2><?= Html::encode($this->title) ?></h2>
</div>

<div class="content with-padding padding-bottom-0  market_create-form">

    <?= $this->render('_form_update', [
        'model' => $model,
    ]) ?>

</div>
