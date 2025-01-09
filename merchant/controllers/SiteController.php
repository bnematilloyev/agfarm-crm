<?php

namespace merchant\controllers;

use common\helpers\DashboardCustomer;
use common\helpers\Utilities;
use common\models\Setting;
use merchant\models\search\OrderCommentSearch;
use merchant\models\search\OrderItemAwaitSearch;
use common\filters\AccessRule;
use common\helpers\DashboardTransaction;
use common\helpers\DashboardUtils;
use common\models\City;
use common\models\constants\GeneralStatus;
use common\models\constants\ProjectType;
use common\models\constants\UserRole;
use common\models\LoginForm;
use common\models\Market;
use common\models\ProjectName;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * Site controller
 */
class SiteController extends BaseController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'ruleConfig' => ['class' => AccessRule::className()],
                'rules' => [
                    [
                        'actions' => ['login', 'akt'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout', 'index', 'error', 'choose-city', 'dashboard', 'order-chart', 'dashboard-info', 'dashboard-debt', 'dashboard-transaction-info', 'dashboard-customer-info', 'dashboard-customer'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * @param null $market_id
     * @return array
     */
    public function actionOrderChart($market_id = null)
    {
        if ($market_id == 0)
            $market_id = null;
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if ($market_id == null && !Yii::$app->user->identity->is_investor)
            $market_id = Yii::$app->user->identity->market_id;
        return DashboardUtils::totalOrder($market_id);
    }

    /**
     * @return array
     */
    public function actionDashboardInfo($market_id = null)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $info = new DashboardUtils('main', $market_id);
        return [
            'today_leasing_count' => $info->today_leasing_count,
            'today_leasing_sum' => $info->today_leasing_sum,
            'total_leasing' => $info->total_leasing,
            'total_sum' => $info->total_sum,
            'total_profit' => $info->total_profit,
            'absent_total_leasing' => $info->absent_total_leasing,
            'absent_total_sum' => $info->absent_total_sum,
        ];
    }

    /**
     * @param null $case
     * @return array
     */
    public function actionDashboardDebt($type = null, $market_id = null)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $info = new DashboardUtils($type, $market_id);
        return [
            'absent_total_leasing_item' => $info->absent_total_leasing_item,
            'absent_total_item_sum' => $info->absent_total_item_sum,
            'expense_company' => $info->expense_company,
            'expense_order' => $info->expense_order
        ];
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index', [
            'project_name' => ProjectName::getMine(ProjectType::LEASING),
            'settings' => Setting::getIndex()
        ]);
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        Yii::$app->layout = 'main-login';
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
                'project_name' => ProjectName::getMine(ProjectType::MERCHANT)
            ]);
        }
    }

    /**
     * Dependent dropdown list
     */
    public function actionChooseCity()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $cities = City::find()->where(['region_id' => $parents[0]])->all();
                foreach ($cities as $city) {
                    /** @var City $city */
                    $out[] = ['id' => $city->id, 'name' => $city->name];
                }
                return ['output' => $out, 'selected' => ''];
            }
        }
        return ['output' => '', 'selected' => ''];
    }

    /**
     * @return \yii\web\Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }


    /**
     * @param $id
     * @return string
     */
    public function actionAkt($id)
    {
        $id = array_reverse(explode(":", base64_decode($id)));
        Yii::$app->response->format = 'pdf';
        Yii::$app->layout = 'pdf';
        return $this->render('act', [
            'model' => $this->findModel($id)
        ]);
    }

    /**
     * @param null $market_id
     * @return array
     */
    public function actionDashboardTransactionInfo($market_id = null, $date_range = null)
    {
        $date_range = explode('—', $date_range);
        if (isset($date_range[0]) && count($date_range) === 2)
            $start_time = strtotime($date_range[0]);
        else $start_time = strtotime("01." . date('m.Y'));

        if (isset($date_range[1]) && count($date_range) === 2)
            $end_time = strtotime($date_range[1]) + 86400;
        else $end_time = strtotime(date('d.m.Y')) + 86400;
        if (Yii::$app->user->identity->role <= UserRole::ROLE_SALER)
            $market_id = Yii::$app->user->identity->market_id;
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $info = new DashboardTransaction($market_id);
        return [
            'total_customer' => $info->total_customer,
            'total_need_money' => $info->total_need_money,
            'total_payed_money' => $info->total_payed_money,
            'total_not_payed_money' => $info->total_not_payed_money,
            'data' => DashboardTransaction::getTransactionByPayment($market_id, $start_time, $end_time),
            'markets' => Market::find()->all(),
        ];
    }

    /**
     * @param $market_id
     * @return array
     */
    public function actionDashboardCustomerInfo()
    {
        $user = Yii::$app->user->identity;
        $market_id = $user->market_id;

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $dashboard_customer = new DashboardCustomer();
        $info = $dashboard_customer->getCustomerDegreeCount($market_id);
        return [
            'total_customer_count' => $info['total_customer_count'],
            'active_customer_count' => $info['active_customer_count'],
            'cancel_customer_count' => $info['cancel_customer_count'],
            'degree_devil' => $info['degree_devil'],
            'degree_fraundster' => $info['degree_fraundster'],
            'degree_negro' => $info['degree_negro'],
            'degree_needy' => $info['degree_needy'],
            'degree_simple' => $info['degree_simple'],
            'degree_bronze' => $info['degree_bronze'],
            'degree_silver' => $info['degree_silver'],
            'degree_gold' => $info['degree_gold'],
            'degree_platinum' => $info['degree_platinum'],
        ];
    }

    public function actionDashboardCustomer()
    {
        return $this->render('dashboard-customer');
    }

}
