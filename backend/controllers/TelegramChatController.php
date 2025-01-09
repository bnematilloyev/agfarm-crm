<?php

namespace backend\controllers;

use common\helpers\Utilities;
use common\models\City;
use common\models\Market;
use common\models\TelegramChat;
use backend\models\search\TelegramChatSearch;
use Yii;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * TelegramChatController implements the CRUD actions for TelegramChat model.
 */
class TelegramChatController extends BaseCreatorController
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
     * Lists all TelegramChat models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TelegramChatSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TelegramChat model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }


    /**
     * Displays a single TelegramChat model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionSendMessage($id)
    {
        $model = $this->findModel($id);
        if ($model->load($this->request->post())) {
            $model->sendMessage();
            return $this->redirect(Yii::$app->request->referrer);
        }
            return $this->renderAjax('custom-message', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new TelegramChat model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TelegramChat();
        $model->setBasics();
        $model->market_id = \Yii::$app->user->identity->market_id;
        if ($model->load($this->request->post())) {
            $model->created_at = Utilities::toUnixDate($model->created_at);
            $model->updated_at = Utilities::toUnixDate($model->updated_at);
            if ($model->save())
                return $this->redirect(['index']);
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing TelegramChat model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post())) {
            $model->updated_at = null;
            $model->updated_at = Utilities::toUnixDate($model->updated_at);
            if ($model->save())
                return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing TelegramChat model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        if(Yii::$app->user->identity->is_Saidjamol)
            $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the TelegramChat model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TelegramChat the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TelegramChat::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    /**
     * Dependent dropdown list
     */
    public function actionChooseMarket()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $companies = Market::find()->where(['company_id' => $parents[0]])->all();
                foreach ($companies as $company) {
                    /** @var City $company */
                    $out[] = ['id' => $company->id, 'name' => $company->name];
                }
                return ['output' => $out, 'selected' => ''];
            }
        }
        return ['output' => '', 'selected' => ''];
    }
}
