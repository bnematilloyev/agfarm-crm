<?php

namespace api\modules\v1\controllers;

use api\behaviours\AdminJwtAuth;
use api\behaviours\Verbcheck;

class BrandsController extends RestController
{
    public function behaviors()
    {

        $behaviors = parent::behaviors();

        return $behaviors + [
                'apiauth' => [
                    'class' => AdminJwtAuth::className(),
                    'exclude' => ['list'],
                ],
                'verbs' => [
                    'class' => Verbcheck::className(),
                    'actions' => [
                        'list' => ['GET'],
                    ],
                ],
            ];
    }
    public function actionList(): array
    {

    }
}