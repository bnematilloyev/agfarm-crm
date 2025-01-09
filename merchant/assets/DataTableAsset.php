<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace merchant\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class DataTableAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = array(
        'plugins/datatable/css/datatable.css',
        'plugins/datatable/css/dataTables.bootstrap.min.css',
        'plugins/datatable/css/bootstrap.min.css',
        'https://cdn.datatables.net/buttons/1.6.0/css/buttons.dataTables.min.css',
        'css/style.css',
        'https://cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css',
        'https://cdn.datatables.net/fixedheader/3.1.8/css/fixedHeader.dataTables.min.css'

    );
    public $js = array(
        'https://code.jquery.com/jquery-3.5.1.js',
        'https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js',
        'https://cdn.datatables.net/fixedheader/3.1.8/js/dataTables.fixedHeader.min.js',
        'plugins/datatable/js/datatable.js',
        'plugins/datatable/js/date-revolution.js',
        'plugins/datatable/js/dataTables.bootstrap.min.js',
        'https://cdn.datatables.net/buttons/1.6.0/js/dataTables.buttons.min.js',
        'https://cdn.datatables.net/buttons/1.6.0/js/buttons.flash.min.js',
        'https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js',
        'https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js',
        'https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js',
        'https://cdn.datatables.net/buttons/1.6.0/js/buttons.html5.min.js',
        'https://cdn.datatables.net/buttons/1.6.0/js/buttons.print.min.js',

    );
    public $depends = array(
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    );
}
