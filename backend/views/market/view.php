<?php

use common\models\constants\GeneralStatus;
use common\models\Market;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Market */
$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Markets'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
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
                'attribute' => 'company_id',
                'value' => function ($model) {
                    /** @var Market $model */
                    return $model->company->name;
                }
            ],
            'created_at:datetime',
            'name',
            'updated_at:datetime',
            'address',
            [
                'attribute' => 'status',
                'value' => function ($model) {
                    /** @var Market $model */
                    return '<div class="status_market_' . $model->status . '">' . $model->statusName . '</div>';
                },
                'format' => 'raw',

                'filter' => GeneralStatus::getList()
            ],
        ],
    ]) ?>
</div>