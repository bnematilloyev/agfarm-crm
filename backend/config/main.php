<?php

use common\helpers\Utilities;

$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'PHONE COLLECTION',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [],
    'language' => 'uz',
    'components' => [
        'response' => [
            'formatters' => [
                'html' => [
                    'class' => 'yii\web\HtmlResponseFormatter',
                ],
                'pdf' => [
                    'class' => 'robregonm\pdf\PdfResponseFormatter',
                    'mode' => '', // Optional
                    'format' => 'letter',  // Optional but recommended. http://mpdf1.com/manual/index.php?tid=184
                    'defaultFontSize' => 11, // Optional
                    'defaultFont' => '', // Optional
                    'marginLeft' => 15, // Optional
                    'marginRight' => 15, // Optional
                    'marginTop' => 20, // Optional
                    'marginBottom' => 15, // Optional
                    'marginHeader' => 10, // Optional
                    'marginFooter' => 10, // Optional
                    //'orientation' => 'Landscape', // optional. This value will be ignored if format is a string value.
                    //** 'options' => [
                    //'title' => 'Document',
                    //mPDF Variables
                    //'fontdata' => [
                    //// ... some fonts. http://mpdf1.com/manual/index.php?tid=454
                    // ]
                    //]**
                ],
            ]
        ],
        'request' => [
            'enableCookieValidation' => true,
            'enableCsrfValidation' => true,
            'cookieValidationKey' => 'ThisIsPhoneCollectionWhichIsInstallmentSystemCookieValidationKey4BackEnd-23g8eb23i',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => Utilities::logConfigs()
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'class' => common\components\LangUrlManager::className(),
            'languages' => ['tr', 'uz', 'ru','en'],
            'enableLocaleUrls' => false,
            'rules' => [
                '/' => 'site/index',
                '<alias:index|videos|login|logout|contact|about|signup|request-password-reset|reset-password|refresh>' => 'site/<alias>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ],
        ],
    ],
    'params' => $params,
];
