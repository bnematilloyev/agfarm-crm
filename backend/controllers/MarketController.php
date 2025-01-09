<?php

namespace backend\controllers;

use backend\models\search\UserSearch;
use common\models\constants\UserRole;
use Yii;
use common\models\Market;
use backend\models\search\MarketSearch;
use yii\db\Exception;
use yii\filters\AccessControl;
use common\filters\AccessRule;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MarketController implements the CRUD actions for Market model.
 */
class MarketController extends BaseController
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
                        'roles' => [UserRole::ROLE_SUPER_ADMIN, UserRole::ROLE_CREATOR],
                    ],
                    [
                        'actions' => ['index', 'view'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
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
     * Lists all Market models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MarketSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all Market models.
     * @return mixed
     */
    public function actionMsIndex()
    {
        $searchModel = new MarketSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('ms-index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Branch model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $market_id = $model->id;

        return $this->render('view', [
            'model' => $model
        ]);
    }

    public function actionViewActions($id)
    {
        $model = $this->findModel($id);
        $searchUserModel = new UserSearch();
        $dataProvider = $searchUserModel->search(Yii::$app->request->queryParams, $id);

        return $this->render('view-actions', [
            'model' => $model,
            'searchUserModel' => $searchUserModel,
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * Creates a new Market model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     * @throws Exception
     */
    public function actionCreate()
    {
        $model = new Market();
        $model->setBasics();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save())
                return $this->redirect(['view', 'id' => $model->id]);
            Yii::$app->session->setFlash('danger', json_encode($model->errors));
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Market model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Market model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        if (Yii::$app->user->identity->is_Saidjamol)
            $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }


    /**
     * Deletes an existing Market model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionBan($id)
    {
        if (Yii::$app->user->identity->is_creator)
            $this->findModel($id)->ban();
        return $this->redirect(['index']);
    }

    /**
     * Finds the Market model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Market the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Market::findOne($id)) !== null && $model->allowed) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
