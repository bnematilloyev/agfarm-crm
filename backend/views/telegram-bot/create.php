<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\TelegramBot */

$this->title = Yii::t('app', 'Create Telegram Bot');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Telegram Bots'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="headline border-0">
    <div class="d-flex align-items-center flex-wrap">
        <button onclick="customNavigate(-1)" class="go_back mr-10"><img src="/images/icons/go_back.svg"></button>
        <h2><?= Html::encode($this->title) ?></h2>
    </div>
</div>

<div class="content with-padding padding-bottom-0 form-create-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
