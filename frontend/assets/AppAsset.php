<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'vendor/css/bootstrap.min.css',
        'vendor/css/animate.css',
        'vendor/css/fontawesome-all.css',
        'vendor/css/themify-icons.css',
        'vendor/css/magnific-popup/magnific-popup.css',
        'vendor/css/owl-carousel/owl.carousel.css',
        'css/spacing.css',
        'css/base.css',
        'css/style.css',
        'css/responsive.css',
        'css/theme-color/theme-color-4.css'
    ];
    public $js = [
        'https://api-maps.yandex.ru/2.1?apikey=933c5302-5ce7-4fc6-9b34-f4e0e4bcc9d1&lang=ru_RU',
        'vendor/js/theme.js',
        'vendor/js/magnific-popup/jquery.magnific-popup.min.js',
        'vendor/js/owl-carousel/owl.carousel.min.js',
        'vendor/js/counter/counter.js',
        'vendor/js/countdown/jquery.countdown.min.js',
        'vendor/js/isotope/isotope.pkgd.min.js',
        'vendor/js/mouse-parallax/tweenmax.min.js',
        'vendor/js/mouse-parallax/jquery-parallax.js',
        'vendor/js/wow.min.js',
        'js/theme-script.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
