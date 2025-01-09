<?php

namespace api\modules\v1\controllers;

use Yii;
use yii\filters\Cors;
use yii\web\Controller;
use yii\web\HeaderCollection;
use yii\web\Response;


class RestController extends Controller
{
    public $request;
    public $enableCsrfValidation = false;
    /** @var $headers HeaderCollection */
    public $headers;


    public function __construct($id, $module, $config = [])
    {
        parent::__construct($id, $module, $config);
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['corsFilter'] = [
            'class' => Cors::className(),
            'cors' => [
                'Origin' => ['*'],
                // 'Access-Control-Allow-Origin' => ['*', 'http://haikuwebapp.local.com:81','http://localhost:81'],
                'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                'Access-Control-Request-Headers' => ['*'],
                'Access-Control-Allow-Credentials' => null,
                'Access-Control-Max-Age' => 86400,
                'Access-Control-Expose-Headers' => []
            ]

        ];
        return $behaviors;
    }

    public function init()
    {

        $this->request = json_decode(file_get_contents('php://input'), true);

        if ($this->request && !is_array($this->request)) {
            Yii::$app->api->sendFailedResponse(['Invalid Json']);
        }

        $this->headers = Yii::$app->getRequest()->getHeaders();
        $language = $this->headers->get('language');
        if ($language && in_array($language, ['uz', 'oz', 'ru', 'en'])) {
            Yii::$app->language = $language;
        }
        Yii::$app->response->format = Response::FORMAT_JSON;
    }
}


