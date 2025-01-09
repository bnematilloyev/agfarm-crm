<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\CurrencyType $model */

$this->title = Yii::t('app', 'Update Currency Type: {name}', [
    'name' => $model->name,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Currency Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="currency-type-update">

    <div class="headline border-0">
        <div class="d-flex align-items-center flex-wrap">
            <button onclick="customNavigate(-1)" class="go_back mr-10"><img src="/images/icons/go_back.svg"></button>
            <h2><?= Html::encode($this->title) ?></h2>
        </div>
    </div>

    <div class="content with-padding padding-bottom-0 comment-update form-create-update">
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>

</div>
