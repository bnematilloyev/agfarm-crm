<?php

namespace backend\controllers;

use common\models\constants\ProductStatus;
use common\models\constants\PublishableStatus;
use common\models\Product;
use backend\models\search\ProductSearch;
use common\widgets\cropper\actions\UploadAction;
use Yii;
use yii\db\Exception;
use yii\db\Query;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends Controller
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

    public function actions()
    {
        return [
            'upload-photo' => [
                'class' => UploadAction::className(),
                'url' => '',
                'path' => '@assets/product/main_image/desktop',
                'second_path' => '@assets/product/main_image/mobile',
                'second_dimension' => [210, 210],
            ]
        ];
    }

    /**
     * Lists all Product models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Product model.
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
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Product();

        if ($this->request->isPost) {
            $model->company_id = Yii::$app->user->identity->company_id;
            $model->creator_id = Yii::$app->user->identity->id;
            $model->updater_admin_id = Yii::$app->user->identity->id;
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Product model.
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
     * Deletes an existing Product model.
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
     * @param null $q
     * @param null $id
     * @return array
     * @throws Exception
     */
    public function actionList($q = null, $id = null, $payment_type = null, $status = true)
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $q = trim($q);
        $out = ['results' => ['id' => '', 'text' => '', 'price' => '']];
        if (!is_null($q)) {
            $query = new Query();
            $query->select('id, name_ru AS text, actual_price')
                ->from('product')
                ->where(['not', ['status' => ProductStatus::STATUS_DELETED]]);
            if ($status) {
                $query->andWhere(['in', 'status', [ProductStatus::STATUS_ACTIVE, ProductStatus::STATUS_ARCHIVED]]);
            }

            if ($q) {
                $keys = explode(' ', $q);
                foreach ($keys as $key) {
                    $query->andWhere(['OR', ['ilike', 'name_ru', $key], ['ilike', 'name_uz', $key], ['ilike', 'name_en', $key]]);
                }
            }

            $query->limit(20);
            $command = $query->createCommand();
            $data = $command->queryAll();
            $out['results'] = array_values($data);
        } elseif ($id > 0) {
            $product = Product::findOne($id);
            $out['results'] = ['id' => $id, 'text' => $product->name_ru, 'price' => $product->actual_price];
        }

        return $out;
    }

    /**
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id IDsi
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Product::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
