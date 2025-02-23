<?php

namespace backend\controllers;

use common\models\ProductOption;
use backend\models\search\ProductOptionSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;

/**
 * ProductOptionController implements the CRUD actions for ProductOption model.
 */
class ProductOptionController extends Controller
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
     * Lists all ProductOption models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ProductOptionSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ProductOption model.
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
     * Creates a new ProductOption model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new ProductOption();

        if ($this->request->isPost && $model->load($this->request->post())) {
            $options = $this->request->post('ProductOption')['options'] ?? [];

            if (!empty($options)) {
                foreach ($options as $option) {
                    $product_option = new ProductOption();
                    $product_option->product_id = $model->product_id;
                    $product_option->option_name = $option['option_name'] ?? null;
                    $product_option->value = $option['value'] ?? null;
                    $product_option->option_type = $option['option_type'] ?? null;

                    if (!$product_option->save()) {
                        Yii::$app->session->setFlash('error', 'Failed to save an option.');
                        var_dump($product_option->getErrors());die();
                        return $this->render('create', ['model' => $model]);
                    }
                }
            }

            return $this->redirect(['view', 'id' => $model->product_id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }


    /**
     * Updates an existing ProductOption model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id IDsi
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing ProductOption model.
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
     * Finds the ProductOption model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id IDsi
     * @return ProductOption the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ProductOption::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
