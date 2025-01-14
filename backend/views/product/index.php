<?php

use common\models\Product;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\jui\AutoComplete;

/** @var yii\web\View $this */
/** @var backend\models\search\ProductSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Products')." 💊 ";
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">

    <div class="headline border-0">
        <div class="d-flex justify-content-between align-items-center flex-wrap">
            <div class="d-flex align-items-center">
                <button onclick="customNavigate(-1)" class="go_back mr-10"><img src="/images/icons/go_back.svg"></button>
                <h2><?= Html::encode($this->title) ?></h2>
            </div>
            <div class="block__w mmt">
                <?= Html::a(Yii::t('app', 'Add Product 📦'), ['create'], ['class' => 'd-inline button ripple-effect green create-buttons']) ?>
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
                ['class' => 'yii\grid\CheckboxColumn'],
                [
                    'headerOptions' => ['width' => '150px'],
                    'attribute' => 'main_image',
                    'format' => 'raw',
                    'value' => function ($model) {
                        $img = "<a href='" . Yii::getAlias('@assets_url/product/main_image/mobile') . $model->main_image . "' data-fancybox=\"images\" >" . Html::img(Yii::getAlias('@assets_url/product/main_image/mobile') . $model->main_image, ['class' => 'img-fluid']) . '</a>';
                        return $img;
                    },
                    'filter' => false,
                ],
                [
                    'headerOptions' => ['width' => '100'],
                    'attribute' => 'id',
                    'format' => 'raw',
                    'value' => function ($model) {
                        /** @var Product $model */
                        return $model->id;
                    }
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
//                    'value' => 'product_brand.name_' . Yii::$app->language,
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
                //'state',
                [
                    'attribute' => 'status',
                    'format' => 'raw',
                    'value' => function ($model) {
                        return \common\models\constants\ProductStatus::getString($model->status);
                    },
                    'filter' => \common\models\constants\ProductStatus::getStatusOnAndOff(),

//                    'visible' => (Yii::$app->user->identity->role != RoleTypes::CALL_CENTER)
                ],
                //'sort',
                //'slug',
                //'images',
                //'video',
                //'meta_json_uz',
                //'meta_json_ru',
                //'meta_json_en',
                //'categories',
                //'similar',
                'actual_price',
                [
                    'attribute' => 'currency_id',
                    'value' => function($model){
                        return $model->currency->name;
                    },
                    'format' => 'raw',
                    'filter' => \common\models\constants\Currency::getArray(),
                ],
                //'old_price',
                //'cost',
                //'trust_percent',
                //'creator_id',
                //'updater_admin_id',
                //'price_changed_at',
                //'stat',
                //'created_at',
                //'updated_at',
                [
                    'class' => ActionColumn::className(),
                    'urlCreator' => function ($action, Product $model, $key, $index, $column) {
                        return Url::toRoute([$action, 'id' => $model->id]);
                     }
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
            url: '/products/product/status',
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
