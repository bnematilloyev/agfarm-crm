<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\TelegramChat */

$this->title = Yii::t('app', 'Update Telegram Chat: {name}', [
    'name' => $model->id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Telegram Chats'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="headline">
    <div class="d-flex align-items-center">
        <button onclick="customNavigate(-1)" class="go_back mr-10"><img src="/images/icons/go_back.svg"></button>
        <h2><?= Html::encode($this->title) ?></h2>
    </div>
</div>

<div class="content with-padding padding-bottom-0 form-create-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
