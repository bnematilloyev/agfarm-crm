<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\ProductOptionType $model */

$this->title = $model->{'name_' . Yii::$app->language};
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Product Option Types'), 'url' => ['index']];
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
            'name_uz',
            'status',
            'name_ru',
            'created_at:date',
            'name_en',
            'updated_at:date',
        ],
    ]) ?>
</div>
