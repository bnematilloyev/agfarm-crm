<?php

use himiklab\yii2\recaptcha\ReCaptchaConfig;

$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'ASAXIY-workify',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'frontend\controllers',
    'bootstrap' => ['log'],
    'language' => 'uz',
    'components' => [
        'request' => [
            'enableCookieValidation' => true,
            'enableCsrfValidation' => true,
            'cookieValidationKey' => 'ThisIsworkifyWhichIsInstallmentSystemCookieValidationKey4Frontend-xliajweofchiuergvcuicjfshk',
        ],
        'reCaptcha' => [
            'class' => ReCaptchaConfig::class,
            'siteKeyV2' => '6LcRD_gjAAAAAOiOFYR-gknFJwC9JRBE-476RwZa',
            'secretV2' => '6LcRD_gjAAAAALxLiIfLcmj2E81r3mgWshTSBdG7'
        ],
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
                    'marginTop' => 15, // Optional
                    'marginBottom' => 0, // Optional
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
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => \common\helpers\Utilities::logConfigs()
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
                'customer/<type>' => 'customer/type',
                'cashback' => 'customer/cashback',
                'dashboard' => 'site/dashboard',
                '<alias:index|videos|login|logout|contact|about|signup|request-password-reset|reset-password|refresh>' => 'site/<alias>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>'
            ],
        ],
    ],
    'params' => $params,
];
