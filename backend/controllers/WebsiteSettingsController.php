<?php

namespace backend\controllers;

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
        return $this->render('product-priority', []);
    }

    public function actionProductPrice()
    {
        return $this->render('product-price', []);
    }
}