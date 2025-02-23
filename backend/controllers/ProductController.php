<?php

namespace backend\controllers;

use backend\models\search\ProductOptionSearch;
use common\helpers\Utilities;
use common\models\constants\ProductStatus;
use common\models\constants\PublishableStatus;
use common\models\Product;
use backend\models\search\ProductSearch;
use common\models\ProductOption;
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
     * Lists all Product models.
     *
     * @return string
     */
    public function actionArchived()
    {
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search_archived($this->request->queryParams);

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
        $searchModel = new ProductOptionSearch();
        $product_options = $searchModel->search_for_product($id);

        return $this->render('view', [
            'model' => $this->findModel($id),
            'product_options' => $product_options,
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
        $user = Yii::$app->user->identity;

        if ($model->load(Yii::$app->request->post()) && Yii::$app->request->isPost) {
            $model->company_id = $user->company_id;
            $model->creator_id = $user->id;
            $model->old_price = 0;
            $model->slug = Utilities::slugify($model->name_uz);
            $model->meta_json_uz = json_encode(array('description' => Utilities::charLimiter($model->description_uz, 30), 'keywords' => $model->name_uz));
            $model->meta_json_ru = json_encode(array('description' => Utilities::charLimiter($model->description_ru, 30), 'keywords' => $model->name_ru));
            $model->meta_json_en = json_encode(array('description' => Utilities::charLimiter($model->description_en, 30), 'keywords' => $model->name_en));

            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('create', ['model' => $model]);
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
        $user = Yii::$app->user->identity;

        if ($model->load(Yii::$app->request->post()) && Yii::$app->request->isPost) {
            $model->updater_admin_id = $user->id;
            $model->old_price = $model->getOldAttribute('actual_price');

            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
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
            $out['results'] = ['id' => $id, 'text' => $product->{"name_".Yii::$app->language}, 'price' => $product->actual_price];
        }

        return $out;
    }

    public function actionSavePriority()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $id = Yii::$app->request->post('id');
        $sort = Yii::$app->request->post('sort');

        if (($model = Product::findOne($id)) !== null) {
            $model->sort = $sort;
            if ($model->save()) {
                return ['success' => true];
            }
        }

        return ['success' => false];
    }

    public function actionSavePrice()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $id = Yii::$app->request->post('id');
        $actualPrice = Yii::$app->request->post('actual_price');
        $cost = Yii::$app->request->post('cost');

        $model = Product::findOne($id);
        if ($model) {
            $model->actual_price = $actualPrice;
            $model->cost = $cost;
            $model->old_price = $model->getOldAttribute('actual_price');
            $model->updater_admin_id = Yii::$app->user->identity->id;
            if ($model->save(false)) {
                return ['success' => true];
            }
        }

        return ['success' => false];
    }

    public function actionStatus()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $product = Product::findOne((Yii::$app->request->post('product_id')));
        $status = Yii::$app->request->post('status');
//        if (!$this->admin->is_Firuz && $product->status == PublishableStatus::STATUS_PUBLISHED && $status != PublishableStatus::STATUS_PUBLISHED) {
//            if (StockService::getQuantity($product->id) > 0) {
//                Yii::$app->session->setFlash('error', 'Mahsulot savdoda borligi sabab statusni o\'zgartirib bo\'lmaydi.');
//                return $this->redirect(Yii::$app->request->referrer);
//            }
//        }
        $product->status = $status;
//        if ($status == PublishableStatus::STATUS_PUBLISHED && $product->state == ProductState::NOT_AVAILABLE)
//            $product->state = ProductState::AVAILABLE;
//        if ($product->status == PublishableStatus::STATUS_WAITING)
//            ProductListItems::removeFromList($product->id);
        if (!$product->save(false)) {
            return $product->errors;
        }
//
//        if ($product->status === PublishableStatus::STATUS_PUBLISHED) {
//            $this->service->synchronisation($product, is_null($product->moysklad_hash));
//        }
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
