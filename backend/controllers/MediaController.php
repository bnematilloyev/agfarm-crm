<?php

/**
 * Created by PhpStorm.
 * User: Husayn Hasanov
 * Date: 10/28/19
 * Time: 8:27 PM
 */

namespace backend\controllers;

use backend\controllers\BaseController;
use backend\models\ImageForm;
use common\helpers\Utilities;
use common\models\DeliveryPointImages;
use common\models\Product;
use Yii;
use yii\helpers\FileHelper;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\UploadedFile;

class MediaController extends BaseController
{
    public function actionUpload()
    {
        $model = new ImageForm();
        $model->imageField = UploadedFile::getInstance($model, 'imageField');
        if (!$model->validate()) {
            return 'validation error';
        }

        $ymd = date('Ymd');
        $pathinfo = pathinfo($model->imageField);
        $filename = md5($pathinfo['filename']) . date('YmdHis') . rand(10000, 99999) . Utilities::generateRandomString();
        $extension = $model->imageField->getExtension();

        // save original file
        $save_path1 = Yii::getAlias('@assets/product/items/desktop/');
        $save_path2 = Yii::getAlias('@assets/product/items/mobile/');
        $save_path3 = Yii::getAlias('@assets/product/items/mini/');

        if ($model->imageField->saveAs(Yii::getAlias('@original_files/products/') . $filename . '.' . $extension)) {
            $file_path = Yii::getAlias('@original_files/products/') . $filename . '.' . $extension;
            copy($file_path, $save_path1 . $filename . '.' . $extension);
            copy($file_path, $save_path2 . $filename . '.' . $extension);
//            Utilities::resizeImage($file_path, $filename.'.'.$extension,-1, 'desktop');
//            Utilities::resizeImage($file_path, $filename.'.'.$extension,-1, 'mobile');
            Utilities::cropImage($file_path, $filename . '.' . $extension, -1, 'mini', 'items');
            $path = Yii::getAlias('@assets_url/product/items/mini') . '/' . $filename . '.' . $extension;

            return Json::encode([
                'files' => [
                    [
                        'name' => $filename . '.' . $extension,
                        'displayName' => mb_substr($filename, 0, 10) . '.' . $extension,
                        'size' => $model->imageField->size,
                        'url' => $path,
                        'thumbnailUrl' => $path,
                        'deleteUrl' => Url::to(['products/media/delete', 'name' => $filename . '.' . $extension]),
                        'deleteType' => 'POST',
                    ],
                ],
            ]);
        }

        return '';
    }

    public function actionInit($id = null)
    {
        if ($id != null) {
            $product = Product::findOne($id);
            $arr = [];
            if (is_array($product->images)) {
                foreach ($product->images as $image) {
                    $filesize = 10;
                    if (file_exists(Yii::getAlias('@assets/product/items/desktop/') . $image)) {
                        $filesize = filesize(Yii::getAlias('@assets/product/items/desktop/') . $image);
                    }

                    $url = Yii::getAlias('@assets_url/product/items/desktop/') . $image;
                    $arr[] = [
                        'name' => $image,
                        'displayName' => mb_substr($image, 0, 10) . mb_substr($image, strrpos($image, '.')),
                        'size' => $filesize,
                        'url' => $url,
                        'thumbnailUrl' => $url,
                        'deleteUrl' => Url::to(['products/media/delete', 'name' => $image]),
                        'deleteType' => 'POST',
                    ];
                }
            }

            return Json::encode([
                'files' => $arr
            ]);
        }

        echo $id;
    }

    public function actionDelete($name)
    {
        $directory = Yii::getAlias('@assets/product/items/desktop/');
//        if ( is_file( Yii::getAlias( '@assets/product/items/desktop/' ) . $name ) ) {
//            unlink( Yii::getAlias( '@assets/product/items/desktop/' ) . $name );
//        }
//        if ( is_file( Yii::getAlias( '@assets/product/items/mobile/' ) . $name ) ) {
//            unlink( Yii::getAlias( '@assets/product/items/mobile/' ) . $name );
//        }
//        if ( is_file( Yii::getAlias( '@assets/product/items/mini/' ) . $name ) ) {
//            unlink( Yii::getAlias( '@assets/product/items/mini/' ) . $name );
//        }
        $files = FileHelper::findFiles($directory);
        $output = [];

        /*foreach ($files as $file) {
            $fileName = basename($file);
            $path = '/img/temp/' . Yii::$app->session->id . DIRECTORY_SEPARATOR . $fileName;
            $output['files'][] = [
                'name' => $fileName,
                'size' => filesize($file),
                'url' => $path,
                'thumbnailUrl' => $path,
                'deleteUrl' => 'image-delete?name=' . $fileName,
                'deleteType' => 'POST',
            ];
        }*/

        return Json::encode($output);
    }

    public function actionDeliveryPointImagesUpload()
    {
        $model = new ImageForm();
        $model->imageField = UploadedFile::getInstance($model, 'imageField');
        if (!$model->validate()) {
            return 'validation error';
        }

        $ymd = date('Ymd');
        $pathinfo = pathinfo($model->imageField);
        $filename = md5($pathinfo['filename']) . date('YmdHis') . rand(10000, 99999) . Utilities::generateRandomString();
        $extension = $model->imageField->getExtension();

        if ($model->imageField->saveAs(Yii::getAlias('@assets/delivery_points/') . $filename . '.' . $extension)) {
            $path = Yii::getAlias('@assets_url/delivery_points') . '/' . $filename . '.' . $extension;

            return Json::encode([
                'files' => [
                    [
                        'name' => $filename . '.' . $extension,
                        'displayName' => mb_substr($filename, 0, 10) . '.' . $extension,
                        'size' => $model->imageField->size,
                        'url' => $path,
                        'thumbnailUrl' => $path,
                        'deleteUrl' => Url::to(['products/media/delivery-point-images-delete', 'name' => $filename . '.' . $extension]),
                        'deleteType' => 'POST',
                    ],
                ],
            ]);
        }

        return '';
    }

    public function actionDeliveryPointImagesInit($id = null)
    {
        if ($id != null) {
            $images = DeliveryPointImages::find()->where(['delivery_point_id' => $id])->select('link')->asArray()->column();
            if (is_array($images)) {
                foreach ($images as $image) {
                    $filesize = 10;
                    if (file_exists(Yii::getAlias('@assets/delivery_points/') . $image)) {
                        $filesize = filesize(Yii::getAlias('@assets/delivery_points/') . $image);
                    }
                    $url = Yii::getAlias('@assets_url/delivery_points/') . $image;
                    $arr[] = [
                        'name' => $image,
                        'displayName' => mb_substr($image, 0, 10) . mb_substr($image, strrpos($image, '.')),
                        'size' => $filesize,
                        'url' => $url,
                        'thumbnailUrl' => $url,
                        'deleteUrl' => Url::to(['products/media/delivery-point-images-delete', 'name' => $image]),
                        'deleteType' => 'POST',
                    ];
                }
            }

            return Json::encode([
                'files' => $arr
            ]);
        }

        echo $id;
    }

    public function actionDeliveryPointImagesDelete($name = null)
    {
        return Json::encode([]);
    }

}
