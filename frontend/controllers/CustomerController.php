<?php

namespace frontend\controllers;

use common\models\constants\CustomerDegree;
use yii\filters\VerbFilter;
use yii\web\Controller;

/**
 * Site controller
 */
class CustomerController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
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
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index', ['degrees' => CustomerDegree::getList()]);
    }

    public function actionCashback()
    {
        return $this->render('cashback');
    }

    public function actionType($type)
    {
        return $this->render($type);
    }
}
