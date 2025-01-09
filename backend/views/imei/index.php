<?php

use common\models\Imei;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var backend\models\search\ImeiSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Imeis');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="headline border-0">
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <div class="d-flex align-items-center">
            <button onclick="customNavigate(-1)" class="go_back mr-10"><img src="/images/icons/go_back.svg"></button>
            <h2><?= Html::encode($this->title) ?></h2>
        </div>
        <div class="block__w mmt">
            <?= Html::a(Yii::t('app', 'Add Imei'), ['create'], ['class' => 'btn btn-success']) ?>
        </div>
    </div>
</div>

<div class="content with-padding padding-bottom-0 main-index-tables">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
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
            [
                'class' => ActionColumn::className(),
                'template' => '{view}',
            ],
        ],
    ]); ?>


</div>
