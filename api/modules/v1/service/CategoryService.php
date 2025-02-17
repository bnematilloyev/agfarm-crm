<?php
/**
 * Created by PhpStorm.
 * User: Saidjamol Qosimxonov
 * Date: 13/12/24
 * Time: 12:37
 */

namespace api\modules\v1\service;

use common\models\constants\GeneralStatus;
use common\models\constants\ProductState;
use common\models\constants\ProductStatus;
use common\models\CurrencyType;
use common\models\Imei;
use common\models\Product;
use common\models\ProductBrand;
use common\models\ProductCategory;
use Yii;

class CategoryService
{

    /**
     * @param $lang
     * @return array
     */
    public static function getProductCategoryList($lang)
    {
        $data = [];
        $models = ProductCategory::find()->where(['status' => GeneralStatus::STATUS_ACTIVE])->all();

        if (!empty($models)) {
            foreach ($models as $model) {
                $data[] = [
                    'id' => $model->id,
                    'name' => $model->{"name_" . $lang},
                    'description' => $model->{"description_" . $lang},
                    'image' => Yii::getAlias('@assets_url/category/mobile').$model->image,
                ];
            }
            return Yii::$app->api->sendSuccessResponse($data);
        } else {
            return Yii::$app->api->sendFailedResponse(Yii::t('api', 'Product category not found'));
        }
    }
    public static function getProductCategorySingle($id, $lang)
    {
        $data = [];
        $category = ProductCategory::findOne($id);

        if (!empty($category)) {
             $data['category'] = [
                 'name' => $category->{"name_" . $lang},
                 'image' => Yii::getAlias('@assets_url/category').$category->image,
                 'description' => $category->{"description_" . $lang}
             ];
             $products = Product::find()
                 ->where(['category_id' => $category->id])
                 ->andWhere(['and', ['status' => ProductStatus::STATUS_ACTIVE], ['in', 'state', [ProductState::AVAILABLE, ProductState::PRE_ORDER]]])
                 ->all();

             if (!empty($products)) {
                 foreach ($products as $product) {
                     $data['products'][] = [
                         'product_id' => $product->id,
                         'name' => $product->{"name_" . $lang},
                         'description' => $product->{"description_" . $lang},
                         'image' => Yii::getAlias('@assets_url/product/mobile').$product->main_image,
                         'price' => $product->actual_price,
                         'currency' => CurrencyType::findOne($product->currency_id)->name,
                     ];
                 }
             }
            return Yii::$app->api->sendSuccessResponse($data);
        } else {
            return Yii::$app->api->sendFailedResponse(Yii::t('api', 'Product category not found'));
        }
    }

}