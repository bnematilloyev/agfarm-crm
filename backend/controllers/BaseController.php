<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;

class BaseController extends Controller
{
    /**
     * @param $action
     * @return bool|\yii\web\Response
     * @throws \yii\web\BadRequestHttpException
     */
    public function beforeAction($action)
    {
        if (Yii::$app->user->isGuest) {
            if ($this->action->id !== 'login') {
                Yii::$app->user->logout();
                $this->redirect(['/site/login']);
                return false;
            }
        }

//        if (!Yii::$app->user->isGuest && !Yii::$app->user->identity->is_operator)
//            Yii::$app->user->logout();
        return parent::beforeAction($action);
    }
}