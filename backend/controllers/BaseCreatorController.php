<?php


namespace backend\controllers;

use Yii;
use yii\web\Controller;

class BaseCreatorController extends Controller
{
    /**
     * @param $action
     * @return bool|\yii\web\Response
     * @throws \yii\web\BadRequestHttpException
     */
    public function beforeAction($action){

        if (($this->action->id !== 'login' && Yii::$app->user->isGuest)) {
            Yii::$app->user->logout();
            $this->redirect(['/site/login']);
            return false;
        }

        if (!Yii::$app->user->identity->is_creator)
            return $this->goHome();
        return parent::beforeAction($action);
    }
}