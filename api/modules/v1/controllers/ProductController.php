<?php

namespace api\modules\v1\controllers;

use api\behaviours\AdminJwtAuth;
use api\behaviours\Verbcheck;
use api\modules\v1\controllers\RestController;
use api\modules\v1\service\ProductService;
use common\helpers\Utilities;
use common\models\constants\GeneralStatus;
use common\models\constants\UserRole;
use common\models\User;
use Exception;
use Yii;

/**
 * Auth controller
 */
class ProductController extends RestController
{
    /**
     * @var ProductService
     */
    private $productService;
    /**
     * @inheritdoc
     */
    public function __construct($id, $module, $config = [])
    {
        $this->productService = new ProductService();
        parent::__construct($id, $module, $config);
    }
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
//                        'department-list' => ['GET'],
                    ],
                ],
            ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ]
        ];
    }

    /**
     * @return array
     */
    public function actionList(): array
    {
        $lang = $this->request['lang'] ?? 'uz';
        return Yii::$app->api->sendSuccessResponse($this->productService->getProductList($lang));
    }

}