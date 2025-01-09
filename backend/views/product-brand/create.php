<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\ProductBrand $model */

$this->title = Yii::t('app', 'Create Product Brand');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Product Brands'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="headline border-0">
    <div class="d-flex align-items-center flex-wrap">
        <button onclick="customNavigate(-1)" class="go_back mr-10"><img src="/images/icons/go_back.svg"></button>
        <h2><?= Html::encode($this->title) ?></h2>
    </div>
</div>

<?= $this->render('_form', [
        'model' => $model,
]) ?>