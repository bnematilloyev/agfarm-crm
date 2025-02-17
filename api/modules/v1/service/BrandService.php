<?php
/**
 * Created by PhpStorm.
 * User: Saidjamol Qosimxonov
 * Date: 13/12/24
 * Time: 12:37
 */

namespace api\modules\v1\service;

use common\models\Imei;
use common\models\Product;
use common\models\ProductBrand;
use Yii;

class BrandService
{

    /**
     * @param $lang
     * @return array
     */
    public static function getProductBrandList($lang)
    {
        $data = [];
        $models = ProductBrand::findActive()->where(['home_page' => true])->all();

        if (!empty($models)) {
            foreach ($models as $model) {
                $data[] = [
                    'id' => $model->id,
                    'name' => $model->{"name_" . $lang},
                    'image' => Yii::getAlias('@assets_url/brand').$model->image,
                ];
            }
            return Yii::$app->api->sendSuccessResponse($data);
        } else {
            return Yii::$app->api->sendFailedResponse(Yii::t('api', 'Product brand not found'));
        }
    }
    public static function getProductBrandSingle($id, $lang)
    {
        $data = [];
        $brand = ProductBrand::findOne($id);

        if (!empty($brand)) {
             $data = [
                 'meta_data' => $brand->{"meta_json_" . $lang},
                 'name' => $brand->{"name_" . $lang},
                 'image' => Yii::getAlias('@assets_url/brand').$brand->image,
                 'wallpaper' => Yii::getAlias('@assets_url/brand/wallpaper').$brand->wallpaper,
                 'description' => $brand->{"description_" . $lang},
                 'official_link' => $brand->official_link,
             ];
            return Yii::$app->api->sendSuccessResponse($data);
        } else {
            return Yii::$app->api->sendFailedResponse(Yii::t('api', 'Product brand not found'));
        }
    }

    public static function getBrandProducts($id, $lang)
    {
        $data = [];
        $products = Product::find()->where(['brand_id' => $id])->limit(10)->all();

        if (!empty($products)) {
            foreach ($products as $product) {
                $data = [
                    'product_id' => $product->id,
                    'name' => $product->{"name_" . $lang},
                    'image' => Yii::getAlias('@assets_url/product/main_image/mobile').$product->{"main_image"},
                ];
            }
            return Yii::$app->api->sendSuccessResponse($data);
        } else {
            return Yii::$app->api->sendFailedResponse(Yii::t('api', 'Products not found'));
        }
    }

}