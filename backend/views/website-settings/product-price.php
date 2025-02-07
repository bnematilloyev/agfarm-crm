<?php

use common\models\Product;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\jui\AutoComplete;

/** @var yii\web\View $this */
/** @var backend\models\search\ProductSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Products Price');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">

    <div class="headline border-0">
        <div class="d-flex justify-content-between align-items-center flex-wrap">
            <div class="d-flex align-items-center">
                <button onclick="customNavigate(-1)" class="go_back mr-10"><img src="/images/icons/go_back.svg"></button>
                <h2><?= Html::encode($this->title) ?></h2>
            </div>
        </div>
    </div>
    <div class="content with-padding padding-bottom-0 main-index-tables">
        <?php \yii\widgets\Pjax::begin(); ?>
        <?= \common\widgets\PageSize::widget(); ?>
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'headerOptions' => ['width' => '150px'],
                    'attribute' => 'main_image',
                    'format' => 'raw',
                    'value' => function ($model) {
                        $img = "<a href='" . Yii::getAlias('@assets_url/product/main_image/mobile') . $model->main_image . "' data-fancybox=\"images\" >" . Html::img(Yii::getAlias('@assets_url/product/main_image/mobile') . $model->main_image, ['class' => 'img-fluid']) . '</a>';
                        return $img;
                    },
                    'filter' => Html::input('text', 'ProductSearch[id]', Yii::$app->request->get('ProductSearch')['id'] ?? '', [
                        'class' => 'form-control',
                    ])
                ],
                [
                    'attribute' => 'category_id',
                    'value' => 'category.name_' . Yii::$app->language,
                    'filter' => \kartik\select2\Select2::widget([
                        'name' => 'ProductSearch[category_id]',
                        'data' => \yii\helpers\ArrayHelper::map(
                            \common\models\ProductCategory::find()->orderBy('name_' . Yii::$app->language . ' asc')->all(),
                            'id',
                            'name_' . Yii::$app->language
                        ),
                        'value' => $searchModel->category_id,
                        'initValueText' => ($searchModel->category_id) ? \common\models\ProductCategory::findOne($searchModel->category_id)->{'name_' . Yii::$app->language} : '',
                        'theme' => \kartik\select2\Select2::THEME_BOOTSTRAP,
                        'options' => [
                            'placeholder' => Yii::t('app', 'Выберите...'),
                            'value' => isset($_GET['ProductSearch[category_id]']) ? $_GET['ProductSearch[category_id]'] : null
                        ],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]),
                ],
                [
                    'attribute' => 'brand_id',
                    'value' => function ($model) {
                        /** @var Product $model */
                        return $model->brand->{'name_' . Yii::$app->language} ?? null; // Handles missing brand gracefully
                    },
                    'filter' => \kartik\select2\Select2::widget([
                        'name' => 'ProductSearch[brand_id]',
                        'data' => \yii\helpers\ArrayHelper::map(
                            \common\models\ProductBrand::find()->orderBy('name_' . Yii::$app->language . ' asc')->all(),
                            'id',
                            'name_' . Yii::$app->language
                        ),
                        'value' => $searchModel->brand_id,
                        'initValueText' => ($searchModel->brand_id) ? \common\models\ProductBrand::findOne($searchModel->brand_id)->{'name_' . Yii::$app->language} : '',
                        'theme' => \kartik\select2\Select2::THEME_BOOTSTRAP,
                        'options' => [
                            'placeholder' => Yii::t('app', 'Выберите...'),
                            'value' => isset($_GET['ProductSearch[brand_id]']) ? $_GET['ProductSearch[brand_id]'] : null
                        ],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]),
                ],
                [
                    'attribute' => 'name_' . Yii::$app->language,
                    'value' => 'name_' . Yii::$app->language,
                    'filter' => AutoComplete::widget([
                        'model' => $searchModel,
                        'attribute' => 'name_' . Yii::$app->language,
                        'clientOptions' => [
                            'source' => Url::to(['ajax/name-autocomplete']),
                            'minLength' => '3',
                            'autoFill' => true,
                        ],
                        'options' => [
                            'class' => 'form-control'
                        ]
                    ])
                ],
                [
                    'attribute' => 'status',
                    'format' => 'raw',
                    'value' => function ($model) {
                        return \common\models\constants\ProductStatus::getString($model->status);
                    },
                    'filter' => \common\models\constants\ProductStatus::getStatusOnAndOff()
                ],
                [
                    'attribute' => 'actual_price',
                    'format' => 'raw',
                    'value' => function ($model) {
                        return Html::input('number', 'actual_price', $model->actual_price, [
                            'class' => 'form-control actual-price-input',
                            'data-id' => $model->id,
                            'style' => 'width: 150px'
                        ]);
                    }
                ],
                [
                    'attribute' => 'currency_id',
                    'value' => function($model){
                        return $model->currency->name;
                    },
                    'format' => 'raw',
                    'filter' => \common\models\constants\Currency::getArray(),
                ],
                'old_price',
                [
                    'attribute' => 'cost',
                    'format' => 'raw',
                    'value' => function ($model) {
                        return Html::input('number', 'cost', $model->cost, [
                            'class' => 'form-control actual-cost-input',
                            'data-id' => $model->id,
                            'style' => 'width: 150px'
                        ]);
                    }
                ],
                [
                    'attribute' => 'creator_id',
                    'format' => 'raw',
                    'value' => function ($model) {
                        return $model->creator->full_name;
                    }
                ],
                [
                    'attribute' => 'updater_admin_id',
                    'format' => 'raw',
                    'value' => function ($model) {
                        return $model->updaterAdmin->full_name;
                    }
                ],
                'trust_percent',
                [
                    'headerOptions' => ['width' => '200'],
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{update}',
                    'header' => Yii::t('app', 'Действии'),
                    'buttons' => [
                        'update' => function ($url, $model) {
                            return Html::a('💾', '#', [
                                'title' => Yii::t('app', 'Update'),
                                'class' => 'btn btn-warning save-price',
                                'data-id' => $model->id
                            ]);
                        }
                    ],
                ],
            ],
        ]); ?>
        <?php \yii\widgets\Pjax::end(); ?>
    </div>

</div>

<script>
    function changeStatus(product_id, obj) {
        let lang = document.documentElement.lang;
        $.ajax({
            url: '/product/status',
            type: 'post',
            data: {product_id: product_id, status: $(obj).find(':selected').val()},
            success: function (response) {
                console.log(response);
            },
            error: function () {
                console.log('internal server error');
            }
        });
    }
</script>

<?php
$js = <<<JS
    $(document).on('click', '.save-price', function() {
    var id = $(this).data('id');
    var actualPrice = $('input.actual-price-input[data-id="' + id + '"]').val();
    var cost = $('input.actual-cost-input[data-id="' + id + '"]').val();

    $.ajax({
        url: '/product/save-price',
        type: 'POST',
        data: { id: id, actual_price: actualPrice, cost: cost },
        success: function(response) {
            if (response.success) {
                alert('Price and cost updated successfully!');
                $.pjax.reload({container: "#p0"});
            } else {
                alert('Error updating price and cost.');
            }
        },
        error: function() {
            alert('Failed to update price and cost.');
        }
    });

    return false;
});

JS;
$this->registerJs($js);
?>


