<?php

namespace frontend\controllers;

use common\helpers\TelegramHelper;
use backend\models\forms\RecordForm;
use common\models\constants\OrderStatus;
use common\models\Customer;
use common\models\Order;
use common\models\OrderItemAwait;
use common\models\User;
use frontend\models\forms\RegistrationForm;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
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
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex()
    {
        $users = User::find()->count('id');
        $clients = Customer::find()->count('id');
        $orders = Order::find()->where(['>', 'status', OrderStatus::STATUS_WAITING])->count('id');
        $awaits = OrderItemAwait::find()->where(['>', 'response', 0])->count('id');
        return $this->render('index', [
            'users' => $users,
            'clients' => $clients,
            'orders' => $orders,
            'awaits' => $awaits
        ]);
    }

    /**
     * @return string
     */
    public function actionService()
    {
        return $this->render('service');
    }

    /**
     * @return string
     * @throws \yii\base\Exception
     */
    public function actionContact()
    {
        $model = new RegistrationForm();
        $model->phone = "+998";
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $telegram = new TelegramHelper(false);
            $telegram->setChatId(866653168);
            $full_name = $model->first_name . " " . $model->last_name . " " . $model->middle_name;
            $text = "Assalomu alaykum! Merchant bolishga taklif tushdi. \n\n " .
                "\xF0\x9F\x91\xA4	Ф.И.О: " . $full_name . "\n" .
                "address: " . $model->address . "\n" .
                "email: " . $model->email . "\n" .
                "Tel raqam: " . ($model->phone) . "\n".
                "Xabar: " . ($model->message) . "\n";
            $telegram->sendMessage($text);
            Yii::$app->session->setFlash('danger', Yii::t('app', "Сизнинг аризангиз муваффақиятли қабул қилинди, бизнинг ходимларимиздан хабарни кутинг"));
            return $this->redirect('site/success');
        }
        return $this->render('contact', [
            'model' => $model
        ]);
    }
    public function actionSuccess(){
        return $this->render('success');
    }

    /**
     * @return string
     */
    public function actionNews()
    {
        return $this->render('news');
    }

    /**
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
