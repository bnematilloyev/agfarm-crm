<?php

namespace backend\controllers;

use common\filters\AccessRule;
use common\helpers\Utilities;
use common\models\constants\ProjectType;
use common\models\constants\UserRole;
use common\models\LoginForm;
use common\models\Market;
use common\models\ProjectName;
use common\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * Site controller
 */
class SiteController extends BaseController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'ruleConfig' => ['class' => AccessRule::className()],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => [UserRole::ROLE_ADMIN, UserRole::ROLE_CREATOR],
                    ],
                    [
                        'actions' => ['login', 'login-via'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout', 'index', 'error'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
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

    /**
     * @return string
     */
    public function actionDashboard()
    {
        $markets = Market::find()->select(['id', 'name'])->asArray()->all();
        return $this->render('dashboard', [
            'markets' => $markets
        ]);
    }

    /**
     * @return string
     */
    public function actionIndex(): string
    {
        return $this->render('index', [
            'project_name' => ProjectName::getMine(ProjectType::CRM)
        ]);
    }

    /**
     * @return string|Response
     */
    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        Yii::$app->layout = 'main-login';
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
                'project_name' => ProjectName::getMine(ProjectType::CRM)
            ]);
        }
        Yii::$app->telegramNotify->sendLoginNotification();
    }

    /**
     * @return string|Response
     */
    public function actionLoginVia($token)
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        if (Yii::$app->user->login(User::findByAuthKey($token), 30 * Utilities::A_DAY)) {
            return $this->goBack();
        }

        return $this->redirect('login');
    }

    /**
     * @return Response
     */
    public function actionLogout(): Response
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }
}
