<?php
/**
 * Created by PhpStorm.
 * User: Saidjamol Qosimxonov
 * Date: 13/12/24
 * Time: 12:37
 */

namespace api\modules\v1\service;

use common\models\Imei;
use Yii;

class ImeiService
{

    /**
     * @param $imei
     * @return array
     */
    public static function checkImei($imei)
    {
        $data = [];
        $model = Imei::findOne(['imei1' => $imei]);
        if ($model == null)
            $model = Imei::findOne(['imei2' => $imei]);
        if ($model) {
            $data[] = [
                'imei1' => $model->imei1,
                'imei2' => $model->imei2,
                'seller' => $model->seller->full_name,
                'buyer' => $model->buyer->full_name,
                'company' => $model->company->name,
                'market' => $model->market->name,
                'product' => $model->product->{'name_' . Yii::$app->language},
                'description' => $model->description,
                'expires_in' => date('d.m.Y', $model->expires_in)
            ];
            return \Yii::$app->api->sendSuccessResponse($data);
        } else
            return \Yii::$app->api->sendFailedResponse(Yii::t('api', 'Imei not found'));
    }
}