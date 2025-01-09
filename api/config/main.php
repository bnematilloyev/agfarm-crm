<?php

$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-api',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'language' => 'uz',
    'modules' => [
        'cabinet' => [
            'basePath' => '@app/modules/cabinet',
            'class' => 'api\modules\cabinet\Module'
        ],
        'admin' => [
            'basePath' => '@app/modules/admin',
            'class' => 'api\modules\admin\Module'
        ],
        'v1' => [
            'basePath' => '@app/modules/v1',
            'class' => 'api\modules\v1\Module'
        ],
        'partner' => [
            'basePath' => '@app/modules/partner',
            'class' => 'api\modules\partner\Module'
        ]
    ],
    'components' => [
        'request' => [
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ],
            'enableCookieValidation' => false,
            'enableCsrfValidation' => true,
            'cookieValidationKey' => 'ThisIsworkifyWhichIsInstallmentSystemCookieValidationKey4Api-lkcnaeljfnvjekbrkjvbakjfbvkrsjkb',
        ],
        'response' => [
            'format' => yii\web\Response::FORMAT_JSON,
            'charset' => 'UTF-8',
            // ...
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => false,
            'identityCookie' => ['name' => '_identity-api', 'httpOnly' => true],
        ],

        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'workify-api',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => \common\helpers\Utilities::logConfigs()
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
                '<controller:(?:\w|-)+>/<id:\d+>' => '<controller>/view',
                '<controller:(?:\w|-)+>/<action:(?:\w|-)+>/<id:\d+>' => '<controller>/<action>',
                '<controller:(?:\w|-)+>/<action:(?:\w|-)+>' => '<controller>/<action>',
                '<module:(?:\w|-)+>/<controller:(?:\w|-)+>/<id:\d+>' => '<module>/<controller>/view',
                '<module:(?:\w|-)+>/<controller:(?:\w|-)+>/<action:(?:\w|-)+>' => '<module>/<controller>/<action>',
                '<module:(?:\w|-)+>/<controller:(?:\w|-)+>/<action:(?:\w|-)+>/<id:\d+>' => '<module>/<controller>/<action>',
            ],
        ],
    ],
    'params' => $params,
];



