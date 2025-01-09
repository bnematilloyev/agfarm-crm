<?php

namespace backend\controllers;

use common\models\Customer;
use common\models\Imei;
use backend\models\search\ImeiSearch;
use Yii;
use yii\db\Exception;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ImeiController implements the CRUD actions for Imei model.
 */
class ImeiController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Imei models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ImeiSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Imei model.
     * @param int $id IDsi
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Imei model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     * @throws Exception
     */
    public function actionCreate()
    {
        $model = new Imei();
        $model->setBasic();

        if ($model->load($this->request->post())) {
            $model->expires_in = strtotime($model->expires_in);
            if ($model->save())
                return $this->redirect(['view', 'id' => $model->id]);
            var_dump($model->firstErrors);
            die();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Imei model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id IDsi
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException|Exception if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->expires_in = date('d.m.Y', strtotime($model->expires_in));

        if ($this->request->isPost && $model->load($this->request->post())) {
            $model->expires_in = strtotime($model->expires_in);
            if ($model->save())
                return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Imei model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id IDsi
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Imei model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id IDsi
     * @return Imei the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Imei::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
