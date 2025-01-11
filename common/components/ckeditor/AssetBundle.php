<?php

namespace common\components\ckeditor;

use yii\web\View;

/**
 * Class AssetBundle
 * @package sadovojav\ckeditor
 */
class AssetBundle extends \yii\web\AssetBundle
{
    public $js = [
        'ckeditor4/ckeditor.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\web\JqueryAsset',
    ];

    public function init()
    {
        $this->sourcePath = __DIR__ . '/assets';
        $this->jsOptions['position'] = View::POS_END;

        parent::init();
    }
}
