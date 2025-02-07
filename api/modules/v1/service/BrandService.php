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
        $model = ProductBrand::findActive()->where(['home_page' => true])->all();
        if ($model) {
            $data[] = [
                'name' => $model->{"name_$lang"},
                'name' => $model->{"name_$lang"},

            ];
            return \Yii::$app->api->sendSuccessResponse($data);
        } else
            return \Yii::$app->api->sendFailedResponse(Yii::t('api', 'Product brand not found'));
    }
}