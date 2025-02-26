<?php

namespace backend\controllers;

use common\helpers\Utilities;
use Yii;
use common\models\ProductBrand;
use backend\models\ProductBrandSearch;
use sultonov\cropper\actions\UploadAction;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProductBrandController implements the CRUD actions for ProductBrand model.
 */
class ProductBrandController extends Controller
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
                'prefixPath' => Yii::getAlias('@assets_url/brand/image/'),
                'path' => '@assets/brand/image/',
            ],
            'upload-wallpaper' => [
                'class' => UploadAction::className(),
                'url' => '',
                'prefixPath' => Yii::getAlias('@assets_url/brand/wallpaper/'),
                'path' => '@assets/brand/wallpaper/',
            ]
        ];
    }

    /**
     * Lists all ProductBrand models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ProductBrandSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ProductBrand model.
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
     * Creates a new ProductBrand model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new ProductBrand();

        if ($model->load(Yii::$app->request->post()) && Yii::$app->request->isPost) {
            $model->slug = Utilities::slugify($model->name_uz);

            $description_uz = mb_substr(strip_tags($model->description_uz), 0, 100, 'UTF-8');
            $description_ru = mb_substr(strip_tags($model->description_ru), 0, 100, 'UTF-8');
            $description_en = mb_substr(strip_tags($model->description_en), 0, 100, 'UTF-8');

            $model->meta_json_uz = json_encode(['description' => $description_uz, 'keywords' => $model->name_uz], JSON_UNESCAPED_UNICODE);
            $model->meta_json_ru = json_encode(['description' => $description_ru, 'keywords' => $model->name_ru], JSON_UNESCAPED_UNICODE);
            $model->meta_json_en = json_encode(['description' => $description_en, 'keywords' => $model->name_en], JSON_UNESCAPED_UNICODE);

            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ProductBrand model.
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
     * Deletes an existing ProductBrand model.
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
     * Finds the ProductBrand model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id IDsi
     * @return ProductBrand the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ProductBrand::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
