<?php

use common\models\Imei;
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Imei $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Imeis'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="headline border-0">
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <h2><?= Yii::t('app', 'Brand') ?></h2>
        <div class="d-flex flex-wrap block__w mmt">
            <?php if (Yii::$app->user->identity->is_developer) {
                echo Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']);
                echo Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                        'method' => 'post',
                    ],
                ]);
            } ?>
        </div>
    </div>
</div>

<div class="content with-padding padding-bottom-0 company-content">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute' => 'company_id',
                'value' => function ($model) {
                    /** @var Imei $model */
                    return $model->company->name;
                }
            ],
            [
                'attribute' => 'market_id',
                'value' => function ($model) {
                    /** @var Imei $model */
                    return $model->market->name;
                }
            ],
            [
                'attribute' => 'seller_id',
                'value' => function ($model) {
                    /** @var Imei $model */
                    return $model->seller->full_name;
                }
            ],
            [
                'attribute' => 'buyer_id',
                'value' => function ($model) {
                    /** @var Imei $model */
                    return $model->buyer->full_name;
                }
            ],
            [
                'attribute' => 'product_id',
                'value' => function ($model) {
                    /** @var Imei $model */
                    return $model->product->name_uz;
                }
            ],
            'imei1',
            'imei2',
            'expires_in:datetime',
            'created_at:datetime',
            'updated_at:datetime',
            'description:ntext'
        ],
    ]) ?>

</div>
