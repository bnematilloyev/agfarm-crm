<?php

namespace api\modules\v1\controllers;

use api\behaviours\ApiJwtAuth;
use api\behaviours\Verbcheck;
use api\modules\v1\service\ImeiService;

class ImeiController extends RestController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        return $behaviors + [
                'apiJwtAuth' => [
                    'class' => ApiJwtAuth::class,
                    'exclude' => ['check'],
                ],
                'verbs' => [
                    'class' => Verbcheck::className(),
                    'actions' => [
                        'check' => ['GET'],
                        'create' => ['POST'],
                    ],

                ],
            ];
    }

    /**
     * @param $imei
     * @return array
     */
    public function actionCheck($imei)
    {
        return ImeiService::checkImei($imei);
    }

}
