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
use common\models\ProductCategory;
use Yii;

class ProductService
{

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
                    $query->with('products');
                }
            ])
            ->asArray()
            ->all();
//        var_dump($parents);

        if (!empty($parents)) {
            $data = [];

            foreach ($parents as $parent) {
                $data[$parent['id']] = [
                    'name' => $parent['name_'.$lang],
                    'sub_categories' => []
                ];

                foreach ($parent['subCategories'] as $subCategory) {
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

                    $data[$parent['id']]['sub_categories'][] = $subData;
                }
            }
//            var_dump($data);die();

            return $data;
        }
    }

}