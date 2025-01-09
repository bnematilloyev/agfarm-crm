<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace backend\assets;


/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends BaseAsset
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css?ver=' . self::VERSION,
        'https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css?ver=' . self::VERSION,
        'css/site.css?ver=' . self::VERSION,
        'css/toastr.css?ver=' . self::VERSION,
        'css/style.css?ver=' . self::VERSION,
        ['css/darkmode.css?ver=' . self::VERSION, 'id' => 'style-switch'],

    ];
    public $js = [
//        'js/jquery-3.4.1.min.js',
        'js/jquery-migrate-3.1.0.min.js?ver=' . self::VERSION,
        'js/mmenu.min.js?ver=' . self::VERSION,
        'js/simplebar.min.js?ver=' . self::VERSION,
        'js/bootstrap-slider.min.js?ver=' . self::VERSION,
        'https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js?ver=' . self::VERSION,
        'js/notify/pnotify.js?ver=' . self::VERSION,
        'js/toastr.min.js?ver=' . self::VERSION,
        'js/custom.js?ver=' . self::VERSION
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'backend\assets\BootstrapAsset',
    ];
}
