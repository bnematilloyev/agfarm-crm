<?php

namespace api\modules\v1\controllers;

use api\behaviours\AdminJwtAuth;
use api\behaviours\Verbcheck;
use api\modules\admin\controllers\RestController;
use api\modules\admin\models\forms\UserForm;
use common\helpers\EmployeeRankHelper;
use common\helpers\Utilities;
use common\models\Branch;
use common\models\constants\EmploymentType;
use common\models\constants\GeneralStatus;
use common\models\constants\UserRole;
use common\models\constants\WeekDay;
use common\models\constants\WorkScheduleConstants;
use common\models\Department;
use common\models\User;
use common\models\UserLocation;
use Exception;
use Yii;
use api\modules\admin\service\AdminService;


/**
 * Auth controller
 */
class ProductController extends RestController
{
    /**
     * @var AdminService
     */
    private $adminService;
    /**
     * @inheritdoc
     */
    public function behaviors()
    {

        $behaviors = parent::behaviors();

        return $behaviors + [
                'apiauth' => [
                    'class' => AdminJwtAuth::className(),
                    'exclude' => [''],
                ],
                'verbs' => [
                    'class' => Verbcheck::className(),
                    'actions' => [
                        'add-employee' => ['POST'],
                        'department-list' => ['GET'],
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
     * @throws Exception
     */
    public function actionAddEmployee(): array
    {
        $userForm = new UserForm();
        $userForm->attributes = Yii::$app->request->post();

        if (!$userForm->validate()) {
            return Yii::$app->api->sendFailedResponse($userForm->getFirstErrorMessage());
        }

        if ($userForm->register()) {
            return Yii::$app->api->sendSuccessResponse();
        }

        return Yii::$app->api->sendFailedResponse(Yii::t('api', 'Произошло ошибка'));
    }

    /**
     * @return array
     */
    public function actionBranchList(): array
    {
        return Yii::$app->api->sendSuccessResponse($this->adminService->getBranches());
    }

}