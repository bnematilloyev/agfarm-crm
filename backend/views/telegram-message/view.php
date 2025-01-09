<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\TelegramMessage $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Telegram Messages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="headline">
    <div class="d-flex justify-content-between align-items-center">
        <h2><?= Html::encode($this->title) ?></h2>
    </div>
</div>

<div class="content with-padding padding-bottom-0">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'tg_id',
            'chat_id',
            'username',
            'tg_first_name',
            'tg_last_name',
            'phone',
            'extra_phone',
            'passer',
            'pasnum',
            'pasdob',
            'first_name',
            'last_name',
            'middle_name',
            'pinfl',
            'region_name',
            'city_name',
            'address',
            'pasimg1',
            'pasimg2',
            'pasimg3',
            'created_at:date',
            'updated_at:date',
        ],
    ]) ?>

</div>
