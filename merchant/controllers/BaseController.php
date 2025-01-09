<?php


namespace merchant\controllers;


use common\services\OnlineUserService;
use Yii;
use yii\web\Controller;

class BaseController extends Controller
{
    /**
     * @param $action
     * @return bool|\yii\web\Response
     * @throws \yii\web\BadRequestHttpException
     */
    public function beforeAction($action){
        if (Yii::$app->user->isGuest) {
            if ($this->action->id !== 'login') {
                Yii::$app->user->logout();
                $this->redirect(['/site/login']);
                return false;
            }
        } else {
            OnlineUserService::updateOnlineUsersActivities();
        }
        return parent::beforeAction($action);
    }
}