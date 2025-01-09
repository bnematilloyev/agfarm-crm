<?php

namespace merchant\controllers;

use common\helpers\SmsHelper;
use merchant\models\search\CustomerWorkSearch;
use common\filters\AccessRule;
use common\models\constants\UserRole;
use common\models\Customer;
use common\models\CustomerWork;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

/**
 * CustomerWorkController implements the CRUD actions for CustomerWork model.
 */
class CustomerWorkController extends BaseController
{
    /**
     * @inheritDoc
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
                        'roles' => [UserRole::ROLE_SUPER_ADMIN],
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
     * Lists all CustomerWork models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CustomerWorkSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CustomerWork model.
     * @param int $id IDsi
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
     * Finds the CustomerWork model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id IDsi
     * @return CustomerWork the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CustomerWork::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    /**
     * action Bulk helps to send messages and get data in xls/xlsx
     *
     */
    public function actionCongratulation()
    {
        $selection = (array)Yii::$app->request->post('selection');
        $customer_ids = CustomerWork::find()->andWhere(['in', 'id', $selection])->select('customer_id')->asArray()->column();
        $customers = Customer::find()->andWhere(['in', 'id', $customer_ids])->all();
        /** @var Customer $customer */
        $message = "Assalomu alaykum aziz va qadrli ustoz! Sizni asaxiy.uz, \"workify\" jamoasi  bugungi sharafli bayramingiz bilan qutlaydi! Sizga xizmat qilishdan doim shodmiz!";
        foreach ($customers as $customer) {
            $smsHelper = new SmsHelper(false, 1);
            $smsHelper->sendSingleMessage($customer->phone, $message);
//            $telegram = new TelegramHelper(false);
//            $telegram->setChatId(-434801333);
//            $telegram->sendMessage($customer->full_name.' ga tabrik sms ketdi');
        }
        return $this->redirect(Yii::$app->request->referrer ?: Yii::$app->homeUrl);
    }
}
