<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Product $model */
/** @var common\models\ProductOption $product_options */

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

    <div class="row">
        <div class="col-md-6">
            <h3><strong><?= Yii::t('app', 'Main'); ?></strong></h3>
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
                        'attribute' => 'creator_id',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->creator ? $model->creator->full_name : Yii::t('app', 'Belgilanmagan');
                        }
                    ],
                    'created_at:datetime',
                    'updated_at:datetime',
                ],
            ]) ?>

            <h3><strong><?= Yii::t('app', 'Name and description'); ?></strong></h3>
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
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
                    'meta_json_uz',
                    'meta_json_ru',
                    'meta_json_en',
                ]
            ]) ?>

            <h3><strong><?= Yii::t('app', 'Price && Cost'); ?></strong></h3>
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
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
                        'attribute' => 'updater_admin_id',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->updaterAdmin ? $model->updaterAdmin->full_name : Yii::t('app', 'Belgilanmagan');
                        }
                    ],
                    'price_changed_at:datetime',
                ]
            ]) ?>
        </div>
        <div class="col-md-6">
            <h3><strong><?= Yii::t('app', 'Rasm va videolar'); ?></strong></h3>
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    [
                        'attribute' => 'main_image',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return Html::img(Yii::getAlias('@assets_url/product/main_image/desktop'.$model->main_image));
                        }
                    ],
                    'images',
                    [
                        'attribute' => 'video',
                        'format' => 'raw',
                        'value' => function ($model) {
                            $videoData = $model->video;
                            $output = '';

                            if (is_array($videoData)) {
                                foreach ($videoData as $item) {
                                    if (isset($item['link'])) {
                                        preg_match('/(?:v=|\/embed\/|youtu\.be\/)([^"&?\/\s]+)/', $item['link'], $matches);
                                        $videoId = $matches[1] ?? null;
                                        $thumbnail = $item['thumbnail'] ?? '';

                                        if ($videoId) {
                                            $output .= "<div style='margin-bottom: 15px;'>
                                        <iframe width='560' height='315' 
                                                src='https://www.youtube.com/embed/{$videoId}' 
                                                frameborder='0' 
                                                allowfullscreen>
                                        </iframe>
                                    </div>";
                                        }
                                    }
                                }
                            }

                            return !empty($output) ? $output : "No videos available";
                        },
                    ],
                ],
            ]) ?>

            <h3><strong><?= Yii::t('app', 'Similar'); ?></strong></h3>
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    [
                        'attribute' => 'categories',
                        'format' => 'raw',
                        'value' => function ($model) {
                            $categoryNames = [];
                            if (is_array($model->categories) && !empty($model->categories)) {
                                $categoryIds = $model->categories;

                                $categoryNames = \common\models\ProductCategory::find()
                                    ->select('name_' . Yii::$app->language)
                                    ->where(['in', 'id',  $categoryIds])
                                    ->column();
                            }
                            return !empty($categoryNames) ? implode(', ', $categoryNames) : Yii::t('app', 'Empty');
                        },
                    ],
                    [
                        'attribute' => 'similar',
                        'format' => 'raw',
                        'value' => function ($model) {
                            if (is_array($model->similar) && !empty($model->similar)) {
                                // Filter out empty values
                                $productIds = array_filter($model->similar['product_id'], function ($id) {
                                    return !empty($id) && is_numeric($id);
                                });

                                if (!empty($productIds)) {
                                    $productNames = \common\models\Product::find()
                                        ->select('name_' . Yii::$app->language)
                                        ->where(['id' => $productIds]) // Valid multiple ID query
                                        ->column();

                                    return !empty($productNames) ? implode(', ', $productNames) : Yii::t('app', 'Empty');
                                }
                            }
                            return Yii::t('app', 'Empty');
                        },
                    ],
                ]
            ]) ?>

            <h3><strong><?= Yii::t('app', 'Product options'); ?></strong></h3>
            <?php if (!empty($product_options)): ?>
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th><?= Yii::t('app', 'Option Name') ?></th>
                        <th><?= Yii::t('app', 'Value') ?></th>
                        <th><?= Yii::t('app', 'Option Type') ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($product_options as $option): ?>
                        <tr>
                            <td><?= Html::encode($option->optionName->{'name_' . Yii::$app->language}) ?></td>
                            <td><?= Html::encode($option->value) ?></td>
                            <td><?= Html::encode($option->optionType->{'name_' . Yii::$app->language}) ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p><?= Yii::t('app', 'No product options available') ?></p>
            <?php endif; ?>

            <h3><strong><?= Yii::t('app', 'Статистика'); ?></strong></h3>
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
                ],
            ]) ?>

        </div>
    </div>
</div>
