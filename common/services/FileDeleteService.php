<?php
/**
 * Created by PhpStorm.
 * User: Husayn Hasanov
 * Telegram: Husayn_Hasanov
 * email: hhs.16051998@gmail.com
 * Date: 04/12/22
 * Time: 23:20
 */

namespace common\services;

class FileDeleteService
{
    public static function deleteFiles($dir)
    {
        foreach (glob($dir . '/*') as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }
    }
}