<?php

use common\models\TelegramMessage;
use common\widgets\PageSize;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var backend\models\search\TelegramMessageSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Telegram Messages');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="headline border-0">
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <h2><?= Html::encode($this->title) ?></h2>
    </div>
</div>

<div class="content with-padding padding-bottom-0 telegram_message_content">
    <?= PageSize::widget(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'filterSelector' => 'select[name="per-page"]',
        'pager' => array(
            'maxButtonCount' => 5,
            'firstPageLabel' => '<i class="icon-material-outline-keyboard-arrow-left"></i>',
            'lastPageLabel' => '<i class="icon-material-outline-keyboard-arrow-right"></i>'
        ),
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'tg_id',
            'chat_id',
            [
                'attribute' => 'pasimg1',
                'format' => 'raw',
                'value' => function (\common\models\TelegramMessage $model) {
                    return '<a class = "seen_telegram_message" href="' . Url::to(["create", "id" => $model->id]) . '" target="_blank" class="button ripple-effect" data-caption="' . $model->full_name . '">Ko\'rish</a>';
                },
                'label' => Yii::t('app', 'Buyruq')
            ],
            [
                'attribute' => 'pasimg1',
                'format' => 'raw',
                'value' => function (\common\models\TelegramMessage $model) {
                    return '<a href="' . $model->pasimg1 . '" data-fancybox="images" data-caption="' . $model->full_name . '">' . Html::img($model->pasimg1, ['width' => '80px']) . '</a>';
                }
            ],
            [
                'attribute' => 'pasimg2',
                'format' => 'raw',
                'value' => function (\common\models\TelegramMessage $model) {
                    return '<a href="' . $model->pasimg2 . '" data-fancybox="images" data-caption="' . $model->full_name . '">' . Html::img($model->pasimg2, ['width' => '80px']) . '</a>';
                }
            ],
            [
                'attribute' => 'pasimg3',
                'format' => 'raw',
                'value' => function (\common\models\TelegramMessage $model) {
                    return '<a href="' . $model->pasimg3 . '" data-fancybox="images" data-caption="' . $model->full_name . '">' . Html::img($model->pasimg3, ['width' => '80px']) . '</a>';
                }
            ],
            'pinfl',
            'first_name',
            'last_name',
            'middle_name',
            [
                'attribute' => 'passer',
                'format' => 'raw',
                'value' => function (\common\models\TelegramMessage $model) {
                    return $model->passer . $model->pasnum;
                }
            ],
//            'pasdob',
            'phone',
            'extra_phone',
            'region_name',
            'city_name',
        ],
    ]); ?>


</div>
