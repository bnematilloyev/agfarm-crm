<?php

namespace merchant\controllers;

use backend\controllers\BaseController;
use common\filters\AccessRule;
use common\helpers\Utilities;
use common\models\AdminWorkSchedule;
use backend\models\search\AdminWorkScheduleSearch;
use common\models\constants\UserRole;
use common\models\User;
use Exception;
use Yii;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * AdminWorkScheduleController implements the CRUD actions for AdminWorkSchedule model.
 */
class AdminWorkScheduleController extends BaseController
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'access' => [
                    'class' => AccessControl::className(),
                    'ruleConfig' => ['class' => AccessRule::className()],
                    'rules' => [
                        [
                            'allow' => true,
                            'roles' => [UserRole::ROLE_SUPER_ADMIN],
                        ],
                        [
                            'actions' => ['index', 'calendar', 'view'],
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
            ]
        );
    }

    /**
     * Lists all AdminWorkSchedule models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new AdminWorkScheduleSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * @param $user_id
     * @param $date_range
     * @return string|Response
     * @throws Exception
     */
    public function actionCalendar($user_id, $date_range = null)
    {
        if (!User::find()->where(['id' => $user_id])->exists()) {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }
        if (isset($date_range)) {
            $result = Utilities::fixDateRange($date_range);
            $beginTime = $result['start_time'];
            $endTime = $result['end_time'];
        } else {
            $beginTime = strtotime(date('1.m.Y'));
            $endTime = strtotime('last day of this month');
        }
        $searchModel = new AdminWorkScheduleSearch();
        $searchModel->admin_id = $user_id;
        $events = $searchModel->getUserActivities($beginTime, $endTime);
        return $this->render('calendar', [
            'full_name' => $searchModel->admin->full_name,
            'events' => $events,
            'from_date' => $beginTime,
            'end_date' => $endTime
        ]);
    }

    /**
     * Displays a single AdminWorkSchedule model.
     * @param int $id ID
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
     * Creates a new AdminWorkSchedule model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new AdminWorkSchedule();

        if ($this->request->isPost) {
            if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->saveAll()) {
                Yii::$app->session->setFlash('success', 'Weekdays saved successfully.');
                return $this->redirect(['index']);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing AdminWorkSchedule model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
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
     * Deletes an existing AdminWorkSchedule model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the AdminWorkSchedule model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return AdminWorkSchedule the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AdminWorkSchedule::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
