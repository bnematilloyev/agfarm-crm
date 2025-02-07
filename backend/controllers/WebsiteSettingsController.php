<?php

namespace backend\controllers;

use backend\models\search\ProductSearch;
use common\filters\AccessRule;
use common\models\constants\UserRole;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

class WebsiteSettingsController extends \backend\controllers\BaseController
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'ruleConfig' => ['class' => AccessRule::className()],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => [UserRole::ROLE_CREATOR, UserRole::ROLE_SUPER_ADMIN]
                    ],
                    [
                        'actions' => ['view', 'upload-photo', 'photo'],
                        'allow' => true,
                        'roles' => ['@']
                    ]
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                    'calc' => ['POST'],
                ],
            ],
        ];
    }

    public function actionProductPriority()
    {
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search_by_priority($this->request->queryParams);

        return $this->render('product-priority', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionProductPrice()
    {
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search_by_price($this->request->queryParams);

        return $this->render('product-price', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}