<?php
/**
 * Created by PhpStorm.
 * User: Saidjamol Qosimxonov
 * Date: 13/12/24
 * Time: 12:37
 */

namespace api\modules\v1\service;

use common\models\Imei;
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

}