<?php

use common\models\Company;
use yii\helpers\Html;
use yii\web\YiiAsset;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Company */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Companies'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
YiiAsset::register($this);
?>
<div class="headline border-0">
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <h2><?= Yii::t('app', 'Kompaniya') ?></h2>
        <div class="d-flex flex-wrap block__w mmt">
            <?= Html::a(Html::img('/images/icons/mode.svg', ['alt' => 'mode', 'style' => 'margin-right:10px;height:17px']) . Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'd-inline mr-5 button ripple-effect text-white', 'style' => 'padding :8px 15px; background-color:#008DFF']) ?>
            <?php if (Yii::$app->user->identity->is_creator)
                echo Html::a(Html::img('/images/icons/Delete.svg', ['alt' => 'Delete', 'style' => 'margin-right:10px']) . Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
                    'class' => 'd-inline mr-5 button ripple-effect red', 'style' => 'padding :8px 15px; background-color:#E83333',
                    'data' => [
                        'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                        'method' => 'post',
                    ],
                ]) ?>
        </div>
    </div>
</div>

<div class="content with-padding padding-bottom-0 company-content">
    <div class="" style="display:flex;justify-content: center;align-items: center; padding: 20px">
        <img src="/images/company-logo.jpg" class="img-rounded" alt="logo">
    </div>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            'created_at:datetime',
            [
                'attribute' => 'address',
                'value' => function ($model) {
                    /** @var Company $model */
                    return $model->address;
                },
                'contentOptions' => ['style' => 'width: 50%;text-align: right;'],
            ],
            'updated_at:datetime',
            'phone',
            [
                'attribute' => 'status',
                'value' => function ($model) {
                    /** @var Company $model */
                    return $model->statusName;
                },
                'contentOptions' => ['class' => 'status_company'],
            ],
        ],
    ]) ?>
</div>
