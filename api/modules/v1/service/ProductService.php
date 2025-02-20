<?php
/**
 * Created by PhpStorm.
 * User: Saidjamol Qosimxonov
 * Date: 13/12/24
 * Time: 12:37
 */

namespace api\modules\v1\service;

use common\models\constants\ProductState;
use common\models\constants\ProductStatus;
use common\models\CurrencyType;
use common\models\Imei;
use common\models\Product;
use common\models\ProductBrand;
use common\models\ProductCategory;
use Yii;

class ProductService
{
    /**
     * @param $lang
     * @return array
     */
    public static function getProductSingle($lang, $product_id)
    {
        $product = Product::findOne($product_id);

        $data = [
            'name' => $product->{"name_".$lang},
            'category' => $product->category->{"name_".$lang},
            'brand' => $product->brand->{"name_".$lang},
            'description' => $product->{"description_".$lang},
            'state' => ProductState::getString($product->state),
            'status' => ProductStatus::getString($product->status),
            'slug' => $product->slug,
            'main_image' => Yii::getAlias('@assets_url/product/main_image/desktop').$product->main_image,
            'price' => $product->actual_price." ".CurrencyType::findOne($product->currency_id)->slug,
        ];

        return  $data;
    }

    /**
     * @param $lang
     * @return array
     */
    public static function getProductList($lang)
    {
        $parents = ProductCategory::find()
            ->where(['parent_id' => null])
            ->with([
                'subCategories' => function ($query) {
                    $query->with([
                        'products',
                        'subCategories' => function ($query) {
                            $query->with('products');
                        }
                    ]);
                }
            ])
            ->asArray()
            ->all();

        if (!empty($parents)) {
            $data = [];

            foreach ($parents as $parent) {
                $data[$parent['id']] = [
                    'name' => $parent['name_'.$lang],
                    'sub_categories' => []
                ];

                foreach ($parent['subCategories'] as $subCategory) {
                    $subData = self::getSubCategoryData($subCategory, $lang);
                    $data[$parent['id']]['sub_categories'][] = $subData;
                }
            }

            return $data;
        }
    }

    private static function getSubCategoryData($subCategory, $lang)
    {
        $subData = [
            'id' => $subCategory['id'],
            'name' => $subCategory['name_'.$lang],
            'products' => []
        ];

        foreach ($subCategory['products'] as $product) {
            $subData['products'][] = [
                'id' => $product['id'],
                'name' => $product['name_'.$lang],
            ];
        }

        if (!empty($subCategory['subCategories'])) {
            $subData['sub_categories'] = [];
            foreach ($subCategory['subCategories'] as $subSubCategory) {
                $subData['sub_categories'][] = self::getSubCategoryData($subSubCategory, $lang);
            }
        }

        return $subData;
    }


}