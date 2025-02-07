<?php

namespace api\modules\v1\controllers;

use api\behaviours\Verbcheck;
use api\modules\v1\controllers\RestController;
use api\modules\v1\models\forms\LoginForm;
use api\modules\v1\models\forms\LoginViaEmailForm;
use api\modules\v1\service\ProfileService;
use common\models\User;
use Yii;
use yii\db\Exception;
use yii\web\UnauthorizedHttpException;

/**
 * Auth controller
 */
class AuthController extends \api\modules\v1\controllers\RestController
{
    /**
     * @var ProfileService
     */
    private $profileService;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {

        $behaviors = parent::behaviors();

        return $behaviors + [
                'verbs' => [
                    'class' => Verbcheck::className(),
                    'actions' => [
                        'send-otp' => ['POST'],
                        'login' => ['POST'],
                        'login-via-email' => ['POST'],
                        'refresh-token' => ['POST'],
                        'register-email' => ['POST'],
                        'me' => ['GET']
                    ],
                ],
            ];
    }

    public function init()
    {
        $this->profileService = new \api\modules\v1\service\ProfileService();
        parent::init();
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

    public function actionLoginViaEmail()
    {
        $model = new LoginViaEmailForm();
        $model->attributes = $this->request;
        // TODO: check the customer exists if it's not exists get passport data and face id photo from user and validate it from MyId and create new customer and delete temporary customer
        if ($result = $model->login()) {
            $result['me'] = $this->profileService->getCurrentUserAsArray();
            return Yii::$app->api->sendSuccessResponse($result);
        }
        return Yii::$app->api->sendFailedResponse(Yii::t('api', "Неправилный логин или пароль"));
    }

    public function actionLogin()
    {
        $model = new LoginForm();
        $model->attributes = $this->request;
        // TODO: check the customer exists if it's not exists get passport data and face id photo from user and validate it from MyId and create new customer and delete temporary customer
        if ($result = $model->login()) {
            $result['me'] = $this->profileService->getCurrentUserAsArray();
            return Yii::$app->api->sendSuccessResponse($result);
        }
        return Yii::$app->api->sendFailedResponse(Yii::t('api', "Неправилный логин или пароль"));
    }

    public function actionRefreshToken()
    {
        $refreshToken = Yii::$app->request->post("refresh_token");
        $jwtService = Yii::$app->jwtService;
        if (!isset($refreshToken) || !$jwtService->validateRefreshToken($refreshToken)) {
            $this->handleUnauthorized();
        }
        $userId = $jwtService->extractSubjectFromRefreshToken($refreshToken);
        if ($user = User::findIdentity($userId)) {
            Yii::$app->user->login($user);
            return Yii::$app->api->sendSuccessResponse($jwtService->getTokenResult(true));
        }
        return $this->handleUnauthorized();
    }

    public function handleUnauthorized()
    {
        throw new UnauthorizedHttpException('Your request was made with invalid credentials.');
    }
}