<?php

namespace api\modules\v1\controllers;

use api\behaviours\AdminJwtAuth;
use api\behaviours\Verbcheck;
use api\modules\v1\service\BrandService;
use api\modules\v1\service\CategoryService;

class CategoryController extends RestController
{
    public function behaviors()
    {

        $behaviors = parent::behaviors();

        return $behaviors + [
                'apiauth' => [
                    'class' => AdminJwtAuth::className(),
                    'exclude' => ['list', 'single'],
                ],
                'verbs' => [
                    'class' => Verbcheck::className(),
                    'actions' => [
                        'list' => ['GET'],
                        'single' => ['GET'],
                    ],
                ],
            ];
    }
    public function actionList(): array
    {
        $lang = $this->request['lang'] ?? 'uz';
        return CategoryService::getProductCategoryList($lang);
    }

    public function actionSingle($id): array
    {
        $lang = $this->request['lang'] ?? 'uz';
        return CategoryService::getProductCategorySingle($id, $lang);
    }
}