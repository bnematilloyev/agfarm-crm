<?php


use common\components\bts\BtsComponent;
use common\services\JwtService;

return [
    'language' => 'uz',
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'timeZone' => 'Asia/Tashkent',
    'components' => [
        'api' => [
            'class' => common\components\Api::className(),
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
            'defaultDuration' => 60 * 5
        ],
        'uniCache' => [
            'class' => 'yii\caching\FileCache',
            'defaultDuration' => 60 * 5
        ],
        'smsCache' => [
            'class' => 'yii\caching\FileCache',
            'defaultDuration' => 60 * 3
        ],
        'bts' => [
            'class' => BtsComponent::class,
            'token' => 'd096d5c3f20ae50c3d9e1508c4cea8da2ae1e163'
        ],
        'i18n' => [
            'translations' => [
                'app*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/messages',
                ],
                'api*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/messages',
                ],
                'backend*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/messages',
                ],
                'yii*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/messages',
                ],
            ],
        ],
        'jwtService' => [
            'class' => JwtService::class
        ],
    ],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
];
