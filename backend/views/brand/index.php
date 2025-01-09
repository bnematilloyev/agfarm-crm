<?php

use yii\helpers\Html;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var backend\models\search\BrandSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Brands');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="headline border-0">
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <div class="d-flex align-items-center">
            <button onclick="customNavigate(-1)" class="go_back mr-10"><img src="/images/icons/go_back.svg"></button>
            <h2><?= Html::encode($this->title) ?></h2>
        </div>
        <div class="block__w mmt">
            <?= Html::a(Yii::t('app', 'Create Brand'), ['create'], ['class' => 'btn btn-success']) ?>
        </div>
    </div>
</div>

<div class="content with-padding padding-bottom-0 main-index-tables">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name_uz',
            'name_en',
            'name_ru',
            'created_at:date',
            [
                'class' => ActionColumn::className(),
                'template' => '{view}'
            ],
        ],
    ]); ?>

</div>
