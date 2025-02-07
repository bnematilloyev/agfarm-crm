<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Product $model */

$this->title = $model->{'name_' . Yii::$app->language};
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Products'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="product-view">

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
            [
                'attribute' => 'company_id',
                'value' => function ($model) {
                    return $model->company->name ?? Yii::t('app', 'Empty');
                },
                'format' => 'raw',
            ],
            [
                'attribute' => 'category_id',
                'value' => function ($model) {
                    return $model->category->{'name_' . Yii::$app->language} ?? Yii::t('app', 'Empty');
                },
                'format' => 'raw',
            ],
            [
                'attribute' => 'brand_id',
                'value' => function ($model) {
                    return $model->brand->{'name_' . Yii::$app->language};
                },
                'format' => 'raw',
            ],
            'name_uz',
            'name_ru',
            'name_en',
            [
                'attribute' => 'description_uz',
                'value' => function ($model) {
                    return $model->description_uz;
                },
                'format' => 'html',
            ],
            [
                'attribute' => 'description_ru',
                'value' => function ($model) {
                    return $model->description_ru;
                },
                'format' => 'html',
            ],
            [
                'attribute' => 'description_en',
                'value' => function ($model) {
                    return $model->description_en;
                },
                'format' => 'html',
            ],
            [
                'attribute' => 'state',
                'value' => function ($model) {
                    return \common\models\constants\ProductState::getString($model->state);
                },
                'format' => 'html',
            ],
            [
                'attribute' => 'status',
                'value' => function ($model) {
                    return \common\models\constants\ProductStatus::getString($model->status);
                },
                'format' => 'html',
            ],
            'sort',
            'slug',
            [
                'attribute' => 'main_image',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::img(Yii::getAlias('@assets_url/product/main_image/desktop'.$model->main_image));
                }
            ],
            'images',
            'video',
            'meta_json_uz',
            'meta_json_ru',
            'meta_json_en',
            [
                'attribute' => 'categories',
                'format' => 'raw',
                'value' => function ($model) {
                    if (is_array($model->categories)) {
                        $categoryIds = $model->categories;
                    } else {
                        $decodedCategories = Html::decode((string)$model->categories);
                        $categoryIds = explode(',', $decodedCategories);
                    }

                    $categoryNames = \common\models\ProductCategory::find()
                        ->select('name_' . Yii::$app->language)
                        ->where(['in', 'id',  $categoryIds])
                        ->column();

                    return !empty($categoryNames) ? implode(', ', $categoryNames) : Yii::t('app', 'Empty');
                },
            ],
            [
                'attribute' => 'similar',
                'format' => 'raw',
                'value' => function ($model) {
                    if (is_array($model->similar)) {
                        $productIds = $model->similar['product_id'];
                    } else {
                        $decodedProducts = Html::decode((string)$model->similar);
                        $productIds = explode(',', $decodedProducts);
                    }

                    $productNames = \common\models\Product::find()
                        ->select('name_' . Yii::$app->language)
                        ->where(['in', 'id', $productIds])
                        ->column();

                    return !empty($productNames) ? implode(', ', $productNames) : Yii::t('app', 'Empty');
                },
            ],
            'actual_price',
            'old_price',
            'cost',
            [
                'attribute' => 'currency_id',
                'format' => 'raw',
                'value' => function ($model) {
                    return \common\models\CurrencyType::findOne($model->currency_id)->name ?? Yii::t('app', 'Belgilanmagan');
                }
            ],
            'trust_percent',
            [
                'attribute' => 'creator_id',
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->creator ? $model->creator->full_name : Yii::t('app', 'Belgilanmagan');
                }
            ],
             [
                'attribute' => 'updater_admin_id',
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->updaterAdmin ? $model->updaterAdmin->full_name : Yii::t('app', 'Belgilanmagan');
                }
             ],
            'price_changed_at:datetime',
            'created_at:datetime',
            'updated_at:datetime',
        ]
    ]) ?>

    <h5><strong><?= Yii::t('app', 'Статистика'); ?></strong></h5>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'label' => Yii::t('app', 'Проголосовали'),
                'value' => $model->stat['vote'] ?? 0
            ],
            [
                'label' => Yii::t('app', 'Читали'),
                'value' => $model->stat['read_count'] ?? 0
            ],
            [
                'label' => Yii::t('app', 'Отзывы'),
                'value' => $model->stat['review_count'] ?? 0
            ],
            [
                'label' => Yii::t('app', 'Пожелали'),
                'value' => $model->stat['wish_count'] ?? 0
            ],
            [
                'label' => Yii::t('app', 'Поделелись'),
                'value' => $model->stat['share_count'] ?? 0
            ],
        ],
    ]) ?>

</div>
