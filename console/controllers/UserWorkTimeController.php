<?php

namespace console\controllers;

use common\services\OnlineUserService;
use yii\console\Controller;
use yii\db\Exception;

class UserWorkTimeController extends Controller
{
    /**
     * @run php yii user-work-time/close-finish-date
     * @return void
     * @throws Exception
     */
    public function actionCloseFinishDate()
    {
        OnlineUserService::closeFinishDate();
    }
}
