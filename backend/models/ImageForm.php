<?php

/**
 * Created by PhpStorm.
 * User: Husayn Hasanov
 * Date: 10/28/19
 * Time: 8:32 PM
 */

namespace backend\models;

use yii\base\Model;

class ImageForm extends Model
{
    public $imageField;

    public function rules()
    {
        return [
            [['imageField'], 'file', 'extensions' => 'gif, jpg, jpeg,webp, png, bmp, svg, mp4, avi, mpg, mkv, flv, wmv'],
        ];
    }

    public function __construct($json = null, $config = [])
    {
        if ($json) {
            $this->imageField = $json;
        }

        parent::__construct($config);
    }
}
