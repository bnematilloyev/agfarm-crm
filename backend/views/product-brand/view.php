<?php

use yii\bootstrap4\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\ProductBrand $model */

$this->title = $model->{'name_'.Yii::$app->language};
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Product Brands'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="product-brand-view">

    <div class="headline border-0">
        <div class="d-flex align-items-center flex-wrap">
            <button onclick="customNavigate(-1)" class="go_back mr-10"><img src="/images/icons/go_back.svg"></button>
            <h2><?= Html::encode($this->title) ?></h2>
        </div>
    </div>

    <div class="d-flex flex-wrap block__w mmt mb-30">
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

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name_uz',
            'name_ru',
            'name_en',
            'slug',
            [
                'attribute' => 'image',
                'format' => 'html',
                'value' => function ($model) {
                    return Html::img(Yii::getAlias('@assets_url/brand/image') . $model->image, ['width' => '200px']);
                },
            ],
            [
                'attribute' => 'wallpaper',
                'format' => 'html',
                'value' => function ($model) {
                    return Html::img(Yii::getAlias('@assets_url/brand/wallpaper') . $model->wallpaper, ['width' => '200px']);
                },
            ],
            'home_page:boolean',
            [
                'attribute' => 'status',
                'value' => function ($model) {
                    return \common\models\constants\GeneralStatus::getString($model->status);
                }
            ],
            [
                'attribute' => 'official_link',
                'format' => 'html',
                'value' => function ($model) {
                    return Html::a($model->official_link, $model->official_link, ['target' => '_blank']);
                }
            ],
            'description_uz',
            'description_ru',
            'description_en',
            'meta_json_uz',
            'meta_json_ru',
            'meta_json_en',
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>

</div>
