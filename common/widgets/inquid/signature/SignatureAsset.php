<?php
/**
 * Created by PhpStorm.
 * User: gogl92
 * Date: 6/10/17
 * Time: 03:05 PM
 */

namespace common\widgets\inquid\signature;

use yii\web\AssetBundle;

class SignatureAsset extends AssetBundle
{
    public $sourcePath = '@common/widgets/inquid/signature/assets/';
    public $css = ['style.css'];
    public $js = ['signature_pad.js','app.js'];
    public $depends = ['yii\web\JqueryAsset'];
}