<?php

namespace app\assets;

use yii\web\AssetBundle;

class MapAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $js = [
        'https://api-maps.yandex.ru/2.1?apikey=3cf9dc24-cdc9-40e7-8a05-50694330af58&lang=ru_RU',
    ];
}
