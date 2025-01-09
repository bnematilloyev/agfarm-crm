<?php

namespace merchant\controllers;

use common\filters\AccessRule;
use common\models\constants\UserRole;
use merchant\models\forms\UserRegisterForm;
use merchant\models\search\UserSearch;
use sultonov\cropper\actions\UploadAction;
use Yii;
use common\models\User;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends BaseController
{
    /**
     * {@inheritdoc}
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
                        'roles' => [UserRole::ROLE_SUPER_ADMIN]
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
                ],
            ],
        ];
    }

    /**
     * @return array
     */
    public function actions()
    {
        return [
            'upload-photo' => [
                'class' => UploadAction::className(),
                'url' => '',
                'prefixPath' => Yii::getAlias('@assets_url/user/'),
                'path' => '@assets/user/',
            ],
        ];
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionAs($id)
    {
        $model = $this->findModel($id);
        if (Yii::$app->user->identity->is_president && $model->role < Yii::$app->user->identity->getAccessRole()) {
            Yii::$app->user->logout();
            Yii::$app->user->login($model, 0);
        }
        return $this->goHome();
    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionPhoto($id)
    {
        $user = $this->findModel($id);
        $userRegisterForm = UserRegisterForm::getForm($user);

        if ($userRegisterForm->load(Yii::$app->request->post()) && $userRegisterForm->validate() && $userRegisterForm->update($user)) {
            return $this->redirect(['view', 'id' => $user->id]);
        }

        return $this->render('photo', [
            'model' => $userRegisterForm,
        ]);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null && $model->getIs_the_market() && $model->getAccessRole() <= Yii::$app->user->identity->getAccessRole()) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
