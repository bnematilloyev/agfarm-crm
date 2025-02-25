<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\ProductOption $model */

$this->title = $model->product->{'name_' . Yii::$app->language};
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Product Options'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="headline border-0 pl-0">
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <div class="d-flex align-items-center flex-wrap">
            <button onclick="customNavigate(-1)" class="go_back mr-10"><img src="/images/icons/go_back.svg">
            </button>
            <h2><?= Html::encode($this->title) ?></h2>
        </div>
        <div class="block__w mmt market_view-buttons">
            <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'd-inline mr-5 button ripple-effect update_button']) ?>
            <?php if (Yii::$app->user->identity->is_creator) echo Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
                'class' => 'd-inline button ripple-effect red delete_button',
                'data' => [
                    'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                    'method' => 'post',
                ],
            ]) ?>
        </div>
    </div>
</div>

<div class="content with-padding padding-bottom-0 market_view-table">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'option_name',
                'value' => function ($model) {
                    return $model->optionName->{'name_' . Yii::$app->language};
                },
                'format' => 'raw',
            ],
            [
                'attribute' => 'status',
                'value' => function ($model) {
                    /** @var \common\models\ProductOption $model */
                    return '<div class="status_market_' . $model->status . '">' . $model->statusName . '</div>';
                },
                'format' => 'raw',

                'filter' => \common\models\constants\GeneralStatus::getList()
            ],
            'value',
            'created_at:datetime',
            [
                'attribute' => 'option_type',
                'value' => function ($model) {
                    return $model->optionType->{'name_' . Yii::$app->language};
                },
                'format' => 'raw',
            ],
            'updated_at:datetime',
        ],
    ]) ?>
</div>
