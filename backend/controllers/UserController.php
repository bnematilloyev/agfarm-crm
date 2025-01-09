<?php

namespace backend\controllers;

use backend\models\forms\UserRegisterForm;
use backend\models\search\UserSearch;
use common\filters\AccessRule;
use common\models\constants\UserRole;
use common\models\User;
use sultonov\cropper\actions\UploadAction;
use Yii;
use yii\db\StaleObjectException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use yii\web\Response;


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
                        'roles' => [UserRole::ROLE_CREATOR, UserRole::ROLE_SUPER_ADMIN]
                    ],
                    [
                        'actions' => ['view'],
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
     * @return string
     */
    public function actionIndex(): string
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
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView(int $id): string
    {
        $model = $this->findModel($id);

        return $this->render('view', compact('model'));
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return Response
     * @throws NotFoundHttpException|\yii\db\Exception if the model cannot be found
     */
    public function actionSwitchStatus(int $id): Response
    {
        $this->findModel($id)->switchStatus();

        return $this->redirect(['view', 'id' => $id]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionAs(int $id): Response
    {
        $model = $this->findModel($id);
        if (Yii::$app->user->identity->is_developer && $model->role <= Yii::$app->user->identity->getAccessRole()) {
            Yii::$app->user->logout();
            Yii::$app->user->login($model, 0);
        }
        return $this->goHome();
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return Response|string
     * @throws \Exception
     */
    public function actionCreate()
    {
        $model = new UserRegisterForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->register()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return Response|string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $user = $this->findModel($id);
        $userRegisterForm = UserRegisterForm::getForm($user);

        if ($userRegisterForm->load(Yii::$app->request->post()) && $userRegisterForm->validate()) {
            return $this->redirect(['view', 'id' => $id]);
        }

        return $this->render('update', [
            'model' => $userRegisterForm,
        ]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param $id
     * @return Response
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws StaleObjectException
     */
    public function actionDelete($id): Response
    {
        if (Yii::$app->user->identity->is_developer)
            $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }


    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel(int $id): User
    {
        if (($model = User::findOne($id)) !== null && $model->getIs_the_market() && $model->getAccessRole() <= Yii::$app->user->identity->getAccessRole()) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
