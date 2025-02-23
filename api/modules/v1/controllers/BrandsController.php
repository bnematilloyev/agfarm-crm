<?php

namespace api\modules\v1\controllers;

use api\behaviours\AdminJwtAuth;
use api\behaviours\Verbcheck;
use api\modules\v1\service\BrandService;

class BrandsController extends RestController
{
    public function behaviors()
    {

        $behaviors = parent::behaviors();

        return $behaviors + [
                'apiauth' => [
                    'class' => AdminJwtAuth::className(),
                    'exclude' => ['list', 'single', 'products'],
                ],
                'verbs' => [
                    'class' => Verbcheck::className(),
                    'actions' => [
                        'list' => ['GET'],
                        'single' => ['GET'],
                        'products' => ['GET'],
                    ],
                ],
            ];
    }
    public function actionList(): array
    {
        $lang = $this->request['lang'] ?? 'uz';
        return BrandService::getProductBrandList($lang);
    }

    public function actionSingle($id): array
    {
        $lang = $this->request['lang'] ?? 'uz';
        return BrandService::getProductBrandSingle($id, $lang);
    }

    public function actionProducts($id): array
    {
        $lang = $this->request['lang'] ?? 'uz';
        return BrandService::getBrandProducts($id, $lang);
    }
}