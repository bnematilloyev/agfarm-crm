<?php

use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\TelegramChat */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Telegram Chats'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="headline border-0">
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <div class="d-flex align-items-center">
            <button onclick="customNavigate(-1)" class="go_back mr-10"><img src="/images/icons/go_back.svg"></button>
            <h2><?= Html::encode($this->title) ?></h2>
        </div>
        <div class="block__w mmt">
            <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'd-inline mr-5 button ripple-effect all-btn-style']) ?>
            <?= Html::a(Yii::t('app', 'Send Message'), null, ['class' => 'd-inline mr-5 button ripple-effect ajax-action all-btn-style', 'data-url' => \yii\helpers\Url::to(['send-message', 'id' => $model->id])]) ?>
            <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
                'class' => 'd-inline button ripple-effect red delete-btn-all',
                'data' => [
                    'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                    'method' => 'post',
                ],
            ]) ?>
        </div>
    </div>
</div>

<div class="content with-padding padding-bottom-0 table-view-content">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
//            'company_id',
            [
                'attribute' => 'company_id',
                'value' => function ($model) {
                    /** @var \common\models\TelegramChat $model */
                    return $model->company->name;
                }
            ],
//            'market_id',
            [
                'attribute' => 'market_id',
                'value' => function ($model) {
                    /** @var \common\models\TelegramChat $model */
                    return $model->market->name;
                }
            ],
            'chat_id',
            'status',

            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>

</div>

<?php
Modal::begin([
    'options' => [
        'id' => 'ajax-action-id',
        'size' => 'modal-lg,',
        'tabindex' => false
    ]
]);
echo "<div id='ajax-action-content'></div>";
Modal::end();
?>

<?php
$js = <<<JS
    $('.ajax-action').on("click", function(){
        $('#ajax-action-content').load($(this).data('url'));
        $('#ajax-action-id').modal().show();
    });
JS;
$this->registerJs($js);
?>
