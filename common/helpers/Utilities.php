<?php
/**
 * Created by PhpStorm.
 * User: Husayn Hasanov
 * Date: 24/07/2018
 * Time: 17:39
 */

namespace common\helpers;

define('FILE_ENCRYPTION_BLOCKS', 10000);

use common\models\ActionCounter;
use common\models\Company;
use common\models\constants\ImageType;
use common\models\constants\PartnerOrderStatus;
use common\models\constants\SmsType;
use common\models\Customer;
use common\models\CustomerCard;
use common\models\CustomerImage;
use common\models\CustomerMarket;
use common\models\LawyerOrders;
use common\models\Market;
use common\models\Order;
use common\models\OrderView;
use common\models\Setting;
use common\models\User;
use DateInterval;
use DateTime;
use Imagine\Image\Box;
use Imagine\Image\Point;
use SimpleXMLElement;
use Yii;
use yii\base\InvalidConfigException;
use yii\bootstrap\Html;
use yii\db\ActiveQuery;
use yii\helpers\StringHelper;
use yii\helpers\Url;
use yii\imagine\Image;

class Utilities
{
    const A_DAY = 86400;
    const AN_HOUR = 3600;
    const TEN_MINUTES = 600;
    const DAILY_WORKING_HOURS = 8;
    const KATM_MINIMUM_SECONDS = 55;
    const A_MILLION = 1000 * 1000;
    const A_MINUTE = 60;
    const A_YEAR = 31536000; //in second
    const A_YEAR_IN_MONTH = 12; //number of month
    const A_MONTH = 30;

    /**
     * @param $array
     * @return string
     */
    public static function addParamToUrl($array)
    {
        $params = $_GET;
        unset($params['language']);
        return Url::to(array_merge([Yii::$app->request->pathInfo], $array));
    }

    public static function addHasClass($controller, $action = null)
    {
        $ok = Yii::$app->controller->id == $controller;
        if ($action != null)
            $ok &= Yii::$app->controller->action->id == $action;
        return $ok ? 'has-class' : '';
    }

    public static function varDumpToString($var)
    {
        ob_start();
        var_dump($var);
        $result = ob_get_clean();
        return $result;
    }

    /**
     * @return string
     */
    public static function GenerateBarcode()
    {
        $numbers = "1234567890123456789123456789098765212345678905123456";
        $numbers = str_shuffle($numbers);
        return "0" . substr($numbers, -8);
    }

    private static function getter($str, $len)
    {
        $length = strlen($str);
        $randomString = '';
        for ($i = 0; $i < $len; $i++) {
            $randomString .= $str[rand(0, $length - 1)];
        }
        return $randomString;
    }

    public static function array2object($array)
    {
        $data = [];
        foreach ($array as $id => $name) {
            $data[] = [
                'id' => $id,
                'name' => $name,
                'url' => PartnerOrderStatus::getUrl($id)
            ];
        }
        return $data;
    }

    public static function generateRandomPassword($lowerAlpha = 3, $digit = 3, $upperAlpha = 2, $char = 2)
    {
        $digits = '0123456789';
        $alpha = 'abcdefghijklmnopqrstuvwxyz';
        $alphA = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $chars = '!@#$%&*()+_-';
        $str = self::getter($alpha, $lowerAlpha) . self::getter($digits, $digit) . self::getter($alphA, $upperAlpha) . self::getter($chars, $char);
        $arr = [];
        for ($i = 0; $i < strlen($str); $i++)
            $arr[] = $str[$i];
        shuffle($arr);
        $str = implode('', $arr);
        return $str;
    }

    public static function randomInt($len = 9)
    {
        $k = rand(1, 9);
        while (--$len)
            $k = $k * 10 + rand(0, 9);
        return $k;
    }

    public static function generateRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public static function array_2d($array, $col_count = 2)
    {
        $result = false;
        if (!empty($array) && is_array($array)) {
            $row_count = ceil(count($array) / $col_count);
            $pointer = 0;
            for ($row = 0; $row < $row_count; $row++) {
                for ($col = 0; $col < $col_count; ++$col) {
                    if (isset($array[$pointer])) {
                        $result[$row][$col] = $array[$pointer];
                        $pointer++;
                    }
                }
            }
        }
        return $result;
    }

    /**
     * @param $timestamp
     * @return int
     * @throws \Exception
     */
    public static function myNextMonth($timestamp)
    {
        $date = new DateTime();
        $date->setTimestamp($timestamp);
        $date->modify('first day of next month');
        return $date->getTimestamp();
    }

    /**
     * @param $timestamp
     * @return int
     * @throws \Exception
     */
    public static function myMonth($timestamp)
    {
        $date = new DateTime();
        $date->setTimestamp($timestamp);
        $date->modify('first day of this month');
        return $date->getTimestamp();
    }

    /**
     * @param $time
     * @return array
     * @throws \Exception
     */
    public static function make_for_between($time)
    {
        return [
            'first' => Utilities::myMonth($time),
            'second' => Utilities::myNextMonth($time)
        ];
    }

    public static function setWaterMark($file_name, $need_original = true)
    {
        /*if ($need_original) {
            if (!Utilities::folder_exist(Yii::getAlias('@assets/products') . $file_name))) {
                mkdir(dirname(Yii::getAlias('@original_files') . $file_name), 0777, true);
            }
            copy(Yii::getAlias('@assets') . $file_name, Yii::getAlias('@original_files') . $file_name);
        }*/
        $type = mime_content_type($file_name);
        switch ($type) {
            case "image/jpeg":
                $image = imagecreatefromjpeg($file_name);
                break;
            case "image/png":
                $image = imagecreatefrompng($file_name);
                break;
            case "image/gif":
                $image = imagecreatefromgif($file_name);
                break;
            default:
                return;
        }
        if ($image) {
            # set dimensions
            $image_width = imagesx($image);
            $image_height = imagesy($image);

            $watermark = Utilities::getResizedWatermark(ceil($image_height / 10), ceil($image_height / 10));

            imagealphablending($watermark, TRUE);

            # create the tile and overlay
            imagesettile($image, $watermark);
            imagefilledrectangle($image, 0, 0, $image_width, $image_height, IMG_COLOR_TILED);

            switch ($type) {
                case "image/jpeg":
                    ImageJpeg($image, $file_name, 100);
                    break;
                case "image/png":
                    ImagePng($image, $file_name, 0);
                    break;
                case "image/gif":
                    ImageGif($image, $file_name);
                    break;
            }

            #clean up
            imagedestroy($image);
            imagedestroy($watermark);
        }
    }

    public static function folder_exist($folder)
    {
        $path = realpath($folder);
        if ($path !== false and is_dir($path)) {
            return true;
        }
        return false;
    }

    public static function getResizedWatermark($w, $h, $crop = FALSE)
    {
        $file = Yii::getAlias('@assets/uploads') . "/original_watermark.png";
        list($width, $height) = getimagesize($file);
        $r = $width / $height;
        if ($crop) {
            if ($width > $height) {
                $width = ceil($width - ($width * abs($r - $w / $h)));
            } else {
                $height = ceil($height - ($height * abs($r - $w / $h)));
            }
            $new_width = $w;
            $new_height = $h;
        } else {
            if ($w / $h > $r) {
                $new_width = $h * $r;
                $new_height = $h;
            } else {
                $new_height = $w / $r;
                $new_width = $w;
            }
        }
        $src = imagecreatefrompng($file);
        $dst = imagecreatetruecolor($new_width, $new_height);
        imagealphablending($dst, false);
        imagesavealpha($dst, true);
        $transparent = imagecolorallocatealpha($dst, 255, 255, 255, 127);
        imagefilledrectangle($dst, 0, 0, $new_width, $new_height, $transparent);
        imagecopyresampled($dst, $src, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
        return $dst;
    }

    public static function slugify($str, $options = array())
    {
        // Make sure string is in UTF-8 and strip invalid UTF-8 characters
        $str = mb_convert_encoding((string)$str, 'UTF-8', mb_list_encodings());

        $defaults = array(
            'delimiter' => '-',
            'limit' => null,
            'lowercase' => true,
            'replacements' => array(),
            'transliterate' => true,
        );

        // Merge options
        $options = array_merge($defaults, $options);

        $char_map = array(
            // Latin
            'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Æ' => 'AE', 'Ç' => 'C',
            'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I',
            'Ð' => 'D', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ő' => 'O',
            'Ø' => 'O', 'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ű' => 'U', 'Ý' => 'Y', 'Þ' => 'TH',
            'ß' => 'ss',
            'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'æ' => 'ae', 'ç' => 'c',
            'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i',
            'ð' => 'd', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ő' => 'o',
            'ø' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ü' => 'u', 'ű' => 'u', 'ý' => 'y', 'þ' => 'th',
            'ÿ' => 'y',
            'ҳ' => 'h',
            'ў' => 'u',
            // Latin symbols
            '©' => '(c)',
            // Greek
            'Α' => 'A', 'Β' => 'B', 'Γ' => 'G', 'Δ' => 'D', 'Ε' => 'E', 'Ζ' => 'Z', 'Η' => 'H', 'Θ' => '8',
            'Ι' => 'I', 'Κ' => 'K', 'Λ' => 'L', 'Μ' => 'M', 'Ν' => 'N', 'Ξ' => '3', 'Ο' => 'O', 'Π' => 'P',
            'Ρ' => 'R', 'Σ' => 'S', 'Τ' => 'T', 'Υ' => 'Y', 'Φ' => 'F', 'Χ' => 'X', 'Ψ' => 'PS', 'Ω' => 'W',
            'Ά' => 'A', 'Έ' => 'E', 'Ί' => 'I', 'Ό' => 'O', 'Ύ' => 'Y', 'Ή' => 'H', 'Ώ' => 'W', 'Ϊ' => 'I',
            'Ϋ' => 'Y',
            'қ' => 'q', 'ғ' => 'g', 'Ў' => 'U', 'Ғ' => 'G', 'Ҳ' => 'H', 'Қ' => 'Q',
            'α' => 'a', 'β' => 'b', 'γ' => 'g', 'δ' => 'd', 'ε' => 'e', 'ζ' => 'z', 'η' => 'h', 'θ' => '8',
            'ι' => 'i', 'κ' => 'k', 'λ' => 'l', 'μ' => 'm', 'ν' => 'n', 'ξ' => '3', 'ο' => 'o', 'π' => 'p',
            'ρ' => 'r', 'σ' => 's', 'τ' => 't', 'υ' => 'y', 'φ' => 'f', 'χ' => 'x', 'ψ' => 'ps', 'ω' => 'w',
            'ά' => 'a', 'έ' => 'e', 'ί' => 'i', 'ό' => 'o', 'ύ' => 'y', 'ή' => 'h', 'ώ' => 'w', 'ς' => 's',
            'ϊ' => 'i', 'ΰ' => 'y', 'ϋ' => 'y', 'ΐ' => 'i',
            // Turkish
            'Ş' => 'S', 'İ' => 'I', 'Ğ' => 'G',
            'ş' => 's', 'ı' => 'i', 'ğ' => 'g',
            // Russian
            'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Д' => 'D', 'Е' => 'E', 'Ё' => 'Yo', 'Ж' => 'Zh',
            'З' => 'Z', 'И' => 'I', 'Й' => 'J', 'К' => 'K', 'Л' => 'L', 'М' => 'M', 'Н' => 'N', 'О' => 'O',
            'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T', 'У' => 'U', 'Ф' => 'F', 'Х' => 'H', 'Ц' => 'C',
            'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Sh', 'Ъ' => '', 'Ы' => 'Y', 'Ь' => '', 'Э' => 'E', 'Ю' => 'Yu',
            'Я' => 'Ya',
            'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'yo', 'ж' => 'zh',
            'з' => 'z', 'и' => 'i', 'й' => 'j', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o',
            'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'c',
            'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sh', 'ъ' => '', 'ы' => 'y', 'ь' => '', 'э' => 'e', 'ю' => 'yu',
            'я' => 'ya',
            // Ukrainian
            'Є' => 'Ye', 'І' => 'I', 'Ї' => 'Yi', 'Ґ' => 'G',
            'є' => 'ye', 'і' => 'i', 'ї' => 'yi', 'ґ' => 'g',
            // Czech
            'Č' => 'C', 'Ď' => 'D', 'Ě' => 'E', 'Ň' => 'N', 'Ř' => 'R', 'Š' => 'S', 'Ť' => 'T', 'Ů' => 'U',
            'Ž' => 'Z',
            'č' => 'c', 'ď' => 'd', 'ě' => 'e', 'ň' => 'n', 'ř' => 'r', 'š' => 's', 'ť' => 't', 'ů' => 'u',
            'ž' => 'z',
            // Polish
            'Ą' => 'A', 'Ć' => 'C', 'Ę' => 'e', 'Ł' => 'L', 'Ń' => 'N', 'Ś' => 'S', 'Ź' => 'Z',
            'Ż' => 'Z',
            'ą' => 'a', 'ć' => 'c', 'ę' => 'e', 'ł' => 'l', 'ń' => 'n', 'ś' => 's', 'ź' => 'z',
            'ż' => 'z',
            // Latvian
            'Ā' => 'A', 'Ē' => 'E', 'Ģ' => 'G', 'Ī' => 'i', 'Ķ' => 'k', 'Ļ' => 'L', 'Ņ' => 'N',
            'Ū' => 'u',
            'ā' => 'a', 'ē' => 'e', 'ģ' => 'g', 'ī' => 'i', 'ķ' => 'k', 'ļ' => 'l', 'ņ' => 'n',
            'ū' => 'u'
        );

        // Make custom replacements
        $str = preg_replace(array_keys($options['replacements']), $options['replacements'], $str);

        // Transliterate characters to ASCII
        if ($options['transliterate']) {
            $str = str_replace(array_keys($char_map), $char_map, $str);
        }

        // Replace non-alphanumeric characters with our delimiter
        $str = preg_replace('/[^\p{L}\p{Nd}]+/u', $options['delimiter'], $str);

        // Remove duplicate delimiters
        $str = preg_replace('/(' . preg_quote($options['delimiter'], '/') . '){2,}/', '$1', $str);

        // Truncate slug to max. characters
        $str = mb_substr($str, 0, ($options['limit'] ? $options['limit'] : mb_strlen($str, 'UTF-8')), 'UTF-8');

        // Remove delimiter from ends
        $str = trim($str, $options['delimiter']);

        return $options['lowercase'] ? mb_strtolower($str, 'UTF-8') : $str;
    }

    public static function ciril2lotin($str, $options = array())
    {
        // Make sure string is in UTF-8 and strip invalid UTF-8 characters
        $str = mb_convert_encoding((string)$str, 'UTF-8', mb_list_encodings());

        $defaults = array(
            'delimiter' => ' ',
            'limit' => null,
            'lowercase' => true,
            'replacements' => array(),
            'transliterate' => true,
        );

        // Merge options
        $options = array_merge($defaults, $options);

        $char_map = array(
            // Russian
            'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Д' => 'D', 'Е' => 'E', 'Ё' => 'Yo', 'Ж' => 'J',
            'З' => 'Z', 'И' => 'I', 'Й' => 'Y', 'К' => 'K', 'Л' => 'L', 'М' => 'M', 'Н' => 'N', 'О' => 'O',
            'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T', 'У' => 'U', 'Ф' => 'F', 'Х' => 'X', 'Ц' => 'Ts',
            'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Sh', 'Ъ' => '', 'Ы' => 'Y', 'Ь' => '', 'Э' => 'E', 'Ю' => 'Yu',
            'Я' => 'Ya', 'Ҳ' => 'X', 'Қ' => 'Q', 'Ғ' => 'G\'', 'Ў' => 'O\'',

            'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'yo', 'ж' => 'j',
            'з' => 'z', 'и' => 'i', 'й' => 'y', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o',
            'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'x', 'ц' => 'ts',
            'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sh', 'ъ' => '', 'ы' => 'y', 'ь' => '', 'э' => 'e', 'ю' => 'yu',
            'я' => 'ya', 'ҳ' => 'x', 'қ' => 'q', 'ғ' => 'g\'', 'ў' => 'o\'',
        );

        // Make custom replacements
        $str = preg_replace(array_keys($options['replacements']), $options['replacements'], $str);

        // Transliterate characters to ASCII
        if ($options['transliterate']) {
            $str = str_replace(array_keys($char_map), $char_map, $str);
        }

        // Replace non-alphanumeric characters with our delimiter
//        $str = preg_replace('/[^\p{L}\p{Nd}]+/u', $options['delimiter'], $str);

        // Remove duplicate delimiters
        $str = preg_replace('/(' . preg_quote($options['delimiter'], '/') . '){2,}/', '$1', $str);

        // Truncate slug to max. characters
        $str = mb_substr($str, 0, ($options['limit'] ? $options['limit'] : mb_strlen($str, 'UTF-8')), 'UTF-8');

        // Remove delimiter from ends
        $str = trim($str, $options['delimiter']);

        return $options['lowercase'] ? mb_strtolower($str, 'UTF-8') : $str;
    }

    public static function getActionColumn($items = [1, 1, 1])
    {
        return [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{view}{update}{delete}',
            'header' => Yii::t('app', 'Действии'),
            'buttons' => [
                'view' => function ($url, $model) use ($items) {
                    if (!$items[0]) return '';
                    return Html::a('<span class="fas fa-eye"></span>', $url, [
                        'title' => Yii::t('app', 'View'),
                        'class' => 'btn btn-info'
                    ]);
                },
                'update' => function ($url, $model) use ($items) {
                    if (!$items[1]) return '';
                    return Html::a('<span class="fas fa-edit"></span>', $url, [
                        'title' => Yii::t('app', 'Update'),
                        'class' => 'btn btn-warning ml-5'
                    ]);
                },
                'delete' => function ($url, $model) use ($items) {
                    if (!$items[2]) return '';
                    return Html::a('<span class="fas fa-trash"></span>', $url, [
                        'title' => Yii::t('app', 'Delete'),
                        'class' => 'btn btn-danger ml-5',
                        'data' => [
                            'confirm' => 'Are you sure you want to delete this item?',
                            'method' => 'post',
                        ],
                    ]);
                },
            ],
        ];
    }

    public static function toStringDate($param, $format = null)
    {
        if ($param == null)
            $param = (new DateTime())->sub(DateInterval::createFromDateString("1 days"));
        try {
            return Yii::$app->formatter->asDate($param, $format);
        } catch (InvalidConfigException $e) {

        }
    }

    public static function toStringDatetime($param, $format = null)
    {
        if ($param == null)
            $param = (new DateTime())->sub(DateInterval::createFromDateString("1 days"));
        try {
            return Yii::$app->formatter->asDatetime($param, $format);
        } catch (InvalidConfigException $e) {

        }
    }

    public static function toUnixDate($param)
    {
        $date = new DateTime($param);
        return $date->getTimestamp();
    }

    public static function encryptFile($source, $key, $destination)
    {
        $key = substr(sha1($key), 0, 16);
        $iv = openssl_random_pseudo_bytes(16);

        $error = false;
        if ($fpOut = fopen($destination, 'w')) {
            fwrite($fpOut, $iv);
            if ($fpIn = fopen($source, 'rb')) {
                while (!feof($fpIn)) {
                    $plaintext = fread($fpIn, 16 * FILE_ENCRYPTION_BLOCKS);
                    $ciphertext = openssl_encrypt($plaintext, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $iv);
                    $iv = substr($ciphertext, 0, 16);
                    fwrite($fpOut, $ciphertext);
                }
                fclose($fpIn);
            } else {
                $error = true;
            }
            fclose($fpOut);
        } else {
            $error = true;
        }

        return $error ? false : $destination;
    }

    public static function aesEncryptForIOS($source, $key, $destination)
    {
        $error = false;
        $iv = openssl_random_pseudo_bytes(16);
        if ($fpOut = fopen($destination, 'w')) {
            //fwrite($fpOut, $iv);
            if ($fpIn = fopen($source, 'rb')) {
                while (!feof($fpIn)) {
                    $plaintext = fread($fpIn, filesize($source));
                    $ciphertext = openssl_encrypt($plaintext, 'AES-256-ECB', $key, OPENSSL_RAW_DATA);
                    //file_put_contents("log.txt", $iv);
                    fwrite($fpOut, $ciphertext);
                }
                fclose($fpIn);
            } else {
                $error = true;
            }
            fclose($fpOut);
        } else {
            $error = true;
        }

        return $error ? false : $destination;
    }

    public static function decrypt($source, $key, $destination)
    {
        $key = substr(sha1($key), 0, 16);
        $error = false;
        if ($fpOut = fopen($destination, 'w')) {
            if ($fpIn = fopen($source, 'rb')) {
                // Get the initialzation vector from the beginning of the file
                $iv = fread($fpIn, 16);
                while (!feof($fpIn)) {
                    $ciphertext = fread($fpIn, 16 * (FILE_ENCRYPTION_BLOCKS + 1)); // we have to read one block more for decrypting than for encrypting
                    $plaintext = openssl_decrypt($ciphertext, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $iv);
                    // Use the first 16 bytes of the ciphertext as the next initialization vector
                    $iv = substr($ciphertext, 0, 16);
                    fwrite($fpOut, $plaintext);
                }
                fclose($fpIn);
            } else {
                $error = true;
            }
            fclose($fpOut);
        } else {
            $error = true;
        }
        // Save content and delete non encrypted file
//        $file_content = file_get_contents($destination); // Read the file's contents
//        if (!unlink($destination))
//            $error = true;
//        if (!$error) {
//            // Get file extension
//            $pieces = explode(".", $destination);
//            array_shift($pieces);
//            $extension = null;
//            foreach ($pieces as $piece) {
//                $extension = $extension . '.' . $piece;
//            }
//        }
        return $error ? false : true;
    }

    public static function getOnlyCharacters($payer, $only_numeric = false)
    {
        if (!is_string($payer))
            $payer = $payer . "";
        $result = "";
        for ($i = 0; $i < strlen($payer); $i++)
            if (is_numeric($payer[$i]) == $only_numeric)
                $result .= $payer[$i];
        return $result;
    }

    public static function getUserIpAddr()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            //ip from share internet
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            //ip pass from proxy
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

    public static function getAgent()
    {
        return $_SERVER['HTTP_USER_AGENT'];
    }

    public static function getUserIp()
    {
        return Yii::$app->getRequest()->getUserIP();
    }

    /**
     * @param int $key
     * @return string
     */
    public static function getWordOfNumber($key)
    {
        switch ($key) {
            case 0:
                return 'one';
            case 1:
                return 'two';
            case 2:
                return 'three';
        }
    }


    public static function changePngToJpg($filePath)
    {
        $image = imagecreatefrompng($filePath);
        imagejpeg($image, $filePath, 100);
        imagedestroy($image);
    }

    public static function resizeImage($file_path, $name, $size, $type)
    {
        $file_name = Yii::getAlias('@assets/product/items/' . $type . '/' . $name);
        Image::getImagine()->open($file_path)->thumbnail(new Box($size, $size))->save($file_name);
//        Utilities::setWaterMark($file_name);
    }

    /**
     * @param $file_path
     * @param $name
     * @param $img_size
     * @param $type
     * @param $folder
     */
    public static function cropImage($file_path, $name, $img_size, $type, $folder)
    {
        $main_image = Image::resize($file_path, $img_size, $img_size)->thumbnail(new Box($img_size, $img_size));
        $size = $main_image->getSize();
        if ($size->getWidth() < $img_size or $size->getHeight() < $img_size) {
            $white = Image::getImagine()->create(new Box($img_size, $img_size));
            $main_image = $white->paste($main_image, new Point($img_size / 2 - $size->getWidth() / 2, $img_size / 2 - $size->getHeight() / 2));
        }
        $file_name = Yii::getAlias('@assets/product/' . $folder . '/' . $type . '/' . $name);
        $main_image->save($file_name);
//        if ($type != 'mini')
//            Utilities::setWaterMark($file_name);
    }

    public static function startsWith($haystack, $needle)
    {
        $length = strlen($needle);
        return (substr($haystack, 0, $length) === $needle);
    }

    public static function endsWith($haystack, $needle)
    {
        $length = strlen($needle);
        if ($length == 0) {
            return true;
        }

        return (substr($haystack, -$length) === $needle);
    }

    public static function str_replace_last($search, $replace, $subject)
    {
        $pos = strrpos($subject, $search);
        if ($pos !== false) {
            $subject = substr_replace($subject, $replace, $pos, strlen($search));
        }
        return $subject;
    }

    public static function mb_ucfirst($string, $encoding = "UTF-8")
    {
        $strlen = mb_strlen($string, $encoding);
        $firstChar = mb_substr($string, 0, 1, $encoding);
        $then = mb_substr($string, 1, $strlen - 1, $encoding);
        return mb_strtoupper($firstChar, $encoding) . $then;
    }

    /**
     * @param bool $num
     * @return bool|string
     */
    public static function numberToWord($num = false)
    {
        if ($num == false || $num == null || $num == 0)
            return " nol ";
        $num = str_replace(array(',', ' '), '', trim($num));
        if (!$num) {
            return false;
        }
        $num = (int)abs($num);
//        $negative = "";
//        if ($num[0] == '-') {
//            $negative = '-';
//            $num = substr($num, 1, strlen($num));
//        }

        $words = array();
        $list1 = array('', 'bir', 'ikki', 'uch', 'to`rt', 'besh', 'olti', 'yetti', 'sakkiz', 'to`qqiz', 'o`n', 'o`n bir',
            'o`n ikki', 'o`n uch', 'o`n to`rt', 'o`n besh', 'o`n olti', 'o`n yetti', 'o`n sakkiz', 'o`n to`qqiz'
        );
        $list2 = array('', 'o`n', 'yigirma', 'o`ttiz', 'qirq', 'ellik', 'oltmish', 'yetmish', 'sakson', 'to`qson', 'yuz');
        $list3 = array('', 'ming', 'million', 'milliard', 'trillion', 'kvadrillion', 'kvintillion', 'sekstillion', 'septillion',
            'oktillion', 'nonillion', 'desillion', 'andesillion', 'duodesillion', 'tredesillion', 'kvattuordesillion',
            'kvindesillion', 'seksdesillion', 'septendesillion', 'oktodesillion', 'novemdesillion', 'vijintillion'
        );
        $num_length = strlen($num);
        $levels = (int)(($num_length + 2) / 3);
        $max_length = $levels * 3;
        $num = substr('00' . $num, -$max_length);
        $num_levels = str_split($num, 3);
        for ($i = 0; $i < count($num_levels); $i++) {
            $levels--;
            $hundreds = (int)($num_levels[$i] / 100);
            $hundreds = ($hundreds ? ' ' . $list1[$hundreds] . ' yuz' . ' ' : '');
            $tens = (int)($num_levels[$i] % 100);
            $singles = '';
            if ($tens < 20) {
                $tens = ($tens ? ' ' . $list1[$tens] . ' ' : '');
            } else {
                $tens = (int)($tens / 10);
                $tens = ' ' . $list2[$tens] . ' ';
                $singles = (int)($num_levels[$i] % 10);
                $singles = ' ' . $list1[$singles] . ' ';
            }
            $words[] = $hundreds . $tens . $singles . (($levels && ( int )($num_levels[$i])) ? ' ' . $list3[$levels] . ' ' : '');
        }
        $commas = count($words);
        if ($commas > 1) {
            $commas = $commas - 1;
        }
        return implode(' ', $words);
    }

    /**
     * @param string $full_name
     */
    public static function send_danger_notify($full_name)
    {
        Yii::$app->session->setFlash('danger', $full_name . " xaridorning to`lov vaqti o`tib ketdi");
    }

    /**
     * @param string $full_name
     * @param int $date
     */
    public static function send_warning_notify($full_name, $date)
    {
        Yii::$app->session->setFlash('warning', $full_name . " xaridorning to`lov vaqtiga oz qoldi, to`lov sanasi: " . date("d.m.Y", $date));
    }

    public static function checkAllCustomer()
    {
        $customers = Customer::find()->all();
        foreach ($customers as $customer)
            $customer->color;
    }

    public static function print_format($amount, $decimals = 2, $dec_point = '.', $thousands_sep = ' ')
    {
        return number_format(doubleval($amount), $decimals, $dec_point, $thousands_sep);
    }

    public static function print_format_comma($amount, $decimals = 2, $dec_point = '.', $thousands_sep = ',')
    {
        return number_format(doubleval($amount), $decimals, $dec_point, $thousands_sep);
    }

    public static function print_formatWithZero($amount, $decimals = 2, $dec_point = '.', $thousands_sep = ' ')
    {
        if (!intval($amount))
            return "0";
        return number_format(doubleval($amount), $decimals, $dec_point, $thousands_sep);
    }

    public static function print_sum($amount, $decimals = 2, $dec_point = '.', $thousands_sep = ' ')
    {
        return number_format(doubleval($amount), $decimals, $dec_point, $thousands_sep) . " so`m";
    }

    public static function controlCustomerCard(CustomerCard $card)
    {
        $card->failed_cnt++;
        $is_blocked = 1;
        for ($i = 1000; $i > 0; $i = intval($i / 10)) {
            $cnt = 5 * $i;
            $time = 600 * $i;
            if ($card->failed_cnt % $cnt == 0) {
                $card->block_till = time() + $time;
                $card->is_blocked = $is_blocked;
                break;
            }
            $is_blocked = 0;
        }
        $card->save();
    }

    public static function clearCustomerCard(CustomerCard $card)
    {
        $card->failed_cnt = 0;
        $card->block_till = 0;
        $card->is_blocked = 0;
        $card->save();
    }

    public static function splitArrayByKey($array, $key, $after = true)
    {
        $position = array_search($key, array_keys($array));

        return array_splice($array, $position);
    }

    public static function getHttpHost()
    {
        return $_SERVER['HTTP_HOST'];
    }

    public static function isLocal(): bool
    {
        return Yii::$app->request->isConsoleRequest || strpos(self::getHttpHost(), 'local') !== false;
    }

    public static function downloadFiles($file_url, $file_dir, $file_name)
    {
        $random_prefix = uniqid("customer-image-") . time() . '-';
        $file_name = str_replace(" ", "-", $file_name);
        $file_name = str_replace(".", "-", $file_name);
        $file_name = str_replace("/", "-", $file_name);
        $new_name = $random_prefix . $file_name . self::fileType($file_url);
        try {
            file_put_contents($file_dir . $new_name, file_get_contents($file_url));
            return $new_name;
        } catch (\Exception $exception) {
            return false;
        }
    }

    public static function saveFiles($file)
    {
        $base64String = $file;
        list($type, $data) = explode(';', $base64String);
        list(, $data) = explode(',', $data);
        $imageData = base64_decode($data);
        $filename = uniqid("customer-image-") . time(); // You can choose the file extension based on the image type
        $filename = str_replace(" ", "-", $filename);
        $filename = str_replace(".", "-", $filename);
        $filename = str_replace("/", "-", $filename);
        $filename .= ".png";
        $filePath = Yii::getAlias('@assets/customer/signature/') . $filename;
        file_put_contents($filePath, $imageData);
        return Yii::getAlias('@assets_url/customer/signature/') . $filename;
    }

    public static function downloadCustomerImage($url, $type_id, $customer_id, $company_id = 1)
    {
        $customer_image = new CustomerImage();
        $customer_image->company_id = $company_id;
        $customer_image->customer_id = $customer_id;
        $customer_image->type = $type_id;
        $customer_image->name = $customer_image->type_name;
        $customer_image->file = self::downloadFiles($url, Yii::getAlias('@assets/customer/image/'), $customer_image->customer->full_name . $customer_image->type_name);
        if ($customer_image->file != false) {
            $customer_image->file = Yii::getAlias('@assets_url/customer/image/') . $customer_image->file;
            return $customer_image->save(false);
        }
        return false;
    }

    public static function saveSignatureImage($data, $customer_id, $type_id = ImageType::SIGNATURE, $company_id = Company::ASAXIY)
    {
        $customer_image = new CustomerImage();
        $customer_image->company_id = $company_id;
        $customer_image->customer_id = $customer_id;
        $customer_image->type = $type_id;
        $customer_image->name = $customer_image->type_name;
        $customer_image->file = self::saveFiles($data);
        return $customer_image->save(false);
    }

    public static function fileType($file_name)
    {
        $temp = explode('.', $file_name);
        return "." . $temp[count($temp) - 1];
    }

    public static function prettyVardump($value)
    {
        echo "<pre>";
        var_dump($value);
        die();
    }

    public static function getDataForSms($type)
    {
        $data = \common\models\Market::find();
        $name = 'name';
        if ($type === \common\models\constants\SmsType::TYPE_CUSTOMER_BY_COMPANY || $type === \common\models\constants\SmsType::TYPE_ORDER_BY_COMPANY || $type == SmsType::TYPE_USER_BY_COMPANY) {
            $data = \common\models\Company::findActive();
            $name = 'name';
        }
        if ($type === \common\models\constants\SmsType::TYPE_CUSTOMER) {
            $data = \common\models\Customer::findActive();
            $name = 'full_name';
        }
        if ($type === \common\models\constants\SmsType::TYPE_ORDER) {
            $data = \common\models\Order::findActive();
            $name = 'cheque';
        }
        if ($type === \common\models\constants\SmsType::TYPE_USER) {
            $data = \common\models\User::findActive();
            $name = 'full_name';
        }
        return [
            'data' => $data,
            'name' => $name
        ];
    }

    public static function getDataForTeamTask()
    {
        $data = \common\models\team\Employee::find();
        $name = 'full_name';
        return [
            'data' => $data,
            'name' => $name
        ];
    }

    public static function getPhonesForSmsConsole($type, $ids)
    {
        if ($type === \common\models\constants\SmsType::TYPE_CUSTOMER) {
            return \common\models\Customer::find()->where(['in', 'id', $ids])->select(['phone'])->asArray()->column();
        }
        if ($type === \common\models\constants\SmsType::TYPE_CUSTOMER_BY_MARKET) {
            $customers = CustomerMarket::find()->where(['in', 'market_id', $ids])->select(['customer_id'])->asArray()->column();
            return \common\models\Customer::find()->where(['in', 'id', $customers])->select(['phone'])->asArray()->column();
        }
        if ($type === \common\models\constants\SmsType::TYPE_USER_BY_COMPANY) {
            $customers = CustomerMarket::find()->where(['in', 'company_id', $ids])->select(['customer_id'])->asArray()->column();
            return \common\models\Customer::find()->where(['in', 'id', $customers])->select(['phone'])->asArray()->column();
        }
        if ($type === \common\models\constants\SmsType::TYPE_ORDER) {
            $customers = Order::find()->where(['in', 'id', $ids])->select(['customer_id'])->asArray()->column();
            return \common\models\Customer::find()->where(['in', 'id', $customers])->select(['phone'])->asArray()->column();
        }
        if ($type === \common\models\constants\SmsType::TYPE_ORDER_BY_MARKET) {
            $customers = Order::find()->where(['in', 'market_id', $ids])->select(['customer_id'])->asArray()->column();
            return \common\models\Customer::find()->where(['in', 'id', $customers])->select(['phone'])->asArray()->column();
        }
        if ($type === \common\models\constants\SmsType::TYPE_CUSTOMER_BY_COMPANY) {
            $customers = Order::find()->where(['in', 'company_id', $ids])->select(['customer_id'])->asArray()->column();
            return \common\models\Customer::find()->where(['in', 'id', $customers])->select(['phone'])->asArray()->column();
        }
        if ($type === \common\models\constants\SmsType::TYPE_USER) {
            return User::find()->where(['in', 'id', $ids])->select(['phone'])->asArray()->column();
        }
        if ($type === \common\models\constants\SmsType::TYPE_USER_BY_MARKET) {
            return User::find()->where(['in', 'market_id', $ids])->select(['phone'])->asArray()->column();
        }
        if ($type === \common\models\constants\SmsType::TYPE_USER_BY_COMPANY) {
            return User::find()->where(['in', 'company_id', $ids])->select(['phone'])->asArray()->column();
        }
        return [];
    }

    public static function timeToMonthYear($date)
    {
        $months = ["", "Yanvar", "Fevral", "Mart", "Aprel", "May", "Iyun", "Iyul", "Avgust", "Sentabr", 'Oktabr', "Noyabr", "Dekabr"];
        $m = date('m', $date);
        return date('Y', $date) . ' yil ' . $months[intval($m)] . " oyi";
    }

    public static function timeToDayMonth($date)
    {
        $months = ["", "yanvar", "fevral", "mart", "aprel", "may", "iyun", "iyul", "avgust", "sentabr", 'oktabr', "noyabr", "dekabr"];
        return intval(date('d', $date)) . "-" . $months[intval(date('m', $date))];
    }

    public static function timeToMonthYear2($date)
    {
        $months = ["", "Yanvar", "Fevral", "Mart", "Aprel", "May", "Iyun", "Iyul", "Avgust", "Sentabr", 'Oktabr', "Noyabr", "Dekabr"];
        $m = date('m', $date);
        return date('Y', $date) . '-yil ' . $months[intval($m)] . " oylik";
    }

    /**
     * @return int
     */
    private static function otpMaxAttemps()
    {
        $setting = Setting::findOne(['name' => 'customer-wrong-otp-cnt']);
        if ($setting == null) {
            $setting = new Setting();
            $setting->name = 'customer-wrong-otp-cnt';
            $setting->value = 3;
            $setting->company_id = 1;
            $setting->market_id = 1;
            $setting->save();
        }
        return (int)$setting->value;
    }

    /**
     * @return int
     */
    public static function otpExpire()
    {
        $setting = Setting::findOne(['name' => 'customer-otp-expire']);
        if ($setting == null) {
            $setting = new Setting();
            $setting->name = 'customer-otp-expire';
            $setting->value = 180;//in seconds
            $setting->company_id = 1;
            $setting->market_id = 1;
            $setting->save();
        }
        return (int)$setting->value;
    }

    /**
     * @return int
     */
    private static function otpSent()
    {
        $setting = Setting::findOne(['name' => 'customer-sent-otp']);
        if ($setting == null) {
            $setting = new Setting();
            $setting->name = 'customer-sent-otp';
            $setting->value = 3;
            $setting->company_id = 1;
            $setting->market_id = 1;
            $setting->save();
        }
        return (int)$setting->value;
    }

    /**
     * @param $customer
     * @return false|\pay\models\Customer
     */
    public static function checkValidCustomer($customer)
    {
        /** @var \pay\models\Customer $customer */
        if ($customer->sent_otp > self::otpSent())
            return false;
        return $customer;
    }

    /**
     * @param $customer
     * @return false|\pay\models\Customer
     */
    public static function checkWrongCustomer($customer)
    {
        /** @var \pay\models\Customer $customer */
        if ($customer->wrong_otp_cnt > self::otpMaxAttemps())
            return false;
        return $customer;
    }

    public static function dateTextFormat($time)
    {
        $time = intval($time);
        $period_texts = ['kun', 'soat', 'minut', 'sekund'];
        $periods = [];
        $periods[] = intval($time / self::A_DAY);
        $periods[] = intval(($time % self::A_DAY) / self::AN_HOUR);
        $periods[] = intval(($time % self::AN_HOUR) / self::A_MINUTE);
        $periods[] = $time % self::A_MINUTE;
        $info = '';
        for ($i = 0; $i < 4; $i++)
            if ($periods[$i])
                $info .= $periods[$i] . ' ' . $period_texts[$i] . ' ';
        return $info;
    }

    public static function getNth_month_date($count, $starts_in)
    {
        $date = new \DateTime(date("d.m.Y", $starts_in));
        while ($count--) {
            $date = $date->modify('first day of next month');
        }
        return self::makePayDate($date, $starts_in);
    }

    /**
     * @param $date
     * @return false|int
     */
    public static function makePayDate($date, $starts_in)
    {
        $year = date('Y', $date->getTimestamp());
        $month = date('m', $date->getTimestamp());
        $days = [0, 31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
        if (self::isLeap($year))
            $days[2] = 29;
        $day = min(intval(date('d', $starts_in)), $days[intval($month)]);
        return strtotime($day . '.' . $month . '.' . $year);
    }

    /**
     * @param $year
     * @return bool
     */
    public static function isLeap($year)
    {
        return $year % 4 == 0 && $year % 100 != 0 || $year % 400 == 0;
    }

    public static function stayOnlyAlpha($text)
    {
        return str_replace(["'", "`", " "], ["", "", ""], $text);
    }

    public static function countAction($action_type, $customer_id, $order_id = null)
    {
        $action = new ActionCounter();
        $user = Yii::$app->user;
        if ($user->isGuest) {
            $action->user = User::ASAXIY_BOT;
        } else {
            $action->user_id = $user->identity->id;
        }
        $action->customer_id = $customer_id;
        $action->order_id = $order_id;
        $action->type = $action_type;
        $action->save();
    }

    /**
     * @param int $user_id
     * @param int $order_id
     * @return OrderView
     */
    public static function createOrderView(int $user_id, int $order_id)
    {
        self::updateExistLawyerLastSeen($user_id, $order_id);
        $date = strtotime(date("d.m.Y"));
        $orderView = OrderView::findOne(['user_id' => $user_id, 'order_id' => $order_id, 'date' => $date]);
        if ($orderView == null) {
            $orderView = new OrderView();
            $orderView->user_id = $user_id;
            $orderView->order_id = $order_id;
            $orderView->date = $date;
            $orderView->count = 0;
            $orderView->save();
            return $orderView;
        }
        $orderView->count++;
        $orderView->save();
        return $orderView;
    }

    public static function updateExistLawyerLastSeen(int $lawyer_id, int $order_id)
    {
        $lawyer = LawyerOrders::findOne(['order_id' => $order_id, 'lawyer_id' => $lawyer_id]);

        if ($lawyer !== null) {
            $lawyer->last_seen = time();
            $lawyer->save();
        }
    }

    /**
     * @param Customer $customer
     * @return string
     */
    public static function generateKeyOfCustomer($customer)
    {
        $link = base64_encode($customer->id . ':' . $customer->created_at);
        $link = str_replace("=", Yii::$app->params['leasing-secret-key'], $link);
        return self::encryptIt($link);
    }

    /**
     * @param Customer $customer
     * @return int|null
     */
    public static function decryptKeyOfCustomer($key)
    {
        $key = self::decryptIt($key);
        $arr = explode(":", base64_decode($key));
        if (isset($arr[0]) && isset($arr[1])) {
            $customer = Customer::findOne($arr[0]);
            if ($customer != null && $customer->created_at == $arr[1])
                return $customer->id;
        }
        return null;
    }

    /**
     * @param $raw
     * @return string
     */
    public static function encryptIt($raw)
    {
        $result = "asaxiy-encryption";
        for ($i = 0; $i < strlen($raw); $i++) {
            $now = $raw[$i];
            if (strtoupper($now) === $now) {
                $result .= "-";
                $now = strtolower($now);
            }
            $result .= $now;
        }
        return $result;
    }

    /**
     * @param $raw
     * @return string
     */
    public static function decryptIt($raw)
    {
        $raw = str_replace("asaxiy-encryption", "", $raw);
        $result = "";
        $is_up = false;
        for ($i = 0; $i < strlen($raw); $i++) {
            $now = $raw[$i];
            if ($now === "-") {
                $is_up = true;
                continue;
            }
            if ($is_up)
                $now = strtoupper($now);
            $result .= $now;
            $is_up = false;
        }
        return $result;
    }

    public static function makeHttps(string $file)
    {
        return "https://" . str_replace("//", "", str_replace(["http://", "https://"], ["", ""], $file));
    }

    public static function fixDateRange($date_range)
    {
        $date_range = explode('—', $date_range);
        if (isset($date_range[0]) && count($date_range) === 2)
            $start_time = strtotime($date_range[0]);
        else $start_time = strtotime("01." . date('m.Y'));

        if (isset($date_range[1]) && count($date_range) === 2)
            $end_time = strtotime($date_range[1]) + self::A_DAY - 1;
        else $end_time = strtotime(date('d.m.Y')) + self::A_DAY - 1;

        return [
            'start_time' => $start_time,
            'end_time' => $end_time
        ];
    }

    /**
     * @param $fullName
     * @return string
     */
    public static function editFullName($fullName)
    {
        return (string)mb_convert_case(mb_strtolower($fullName, 'UTF-8'), MB_CASE_TITLE, 'UTF-8');
    }

    public static function generateSecurityKey($second = 60)
    {
        $current_time = time();
        $interval = floor($current_time / $second);
        $data = \Yii::$app->params['hatico-service-key'] . $interval;
        return hash('sha256', $data);
    }

    public static function checkAuthorization($token)
    {
        return $token !== self::generateSecurityKey(300);
    }

    /**
     * @return string
     */
    public static function generateUUID(): string
    {
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }

    public static function setInQueue2Inform(string $key, int $id)
    {
        file_put_contents('/var/www/murobahauz/console/controllers/' . $key . '/' . $id . '-' . time() . ".txt", $id);
    }

    public static function domNodeToArray($node)
    {
        $output = array();
        if ($node->nodeType === XML_TEXT_NODE) {
            $output = $node->nodeValue;
        } else {
            if ($node->hasAttributes()) {
                foreach ($node->attributes as $attr) {
                    $output['@' . $attr->nodeName] = $attr->nodeValue;
                }
            }
            if ($node->hasChildNodes()) {
                foreach ($node->childNodes as $child) {
                    $childOutput = self::domNodeToArray($child);
                    if (isset($childOutput)) {
                        if ($child->nodeType === XML_TEXT_NODE) {
                            $output = $childOutput;
                        } else {
                            if (isset($childOutput['@value'])) {
                                $output[$child->nodeName] = $childOutput['@value'];
                            } else {
                                $output[$child->nodeName][] = $childOutput;
                            }
                        }
                    }
                }
            }
        }
        return $output;
    }


    /**
     * Create plain PHP associative array from XML.
     *
     * Example usage:
     *   $xmlNode = simplexml_load_file('example.xml');
     *   $arrayData = xmlToArray($xmlNode);
     *   echo json_encode($arrayData);
     *
     * @param SimpleXMLElement $xml The root node
     * @param array $options Associative array of options
     * @return array
     * @link http://outlandishideas.co.uk/blog/2012/08/xml-to-json/ More info
     * @author Tamlyn Rhodes <http://tamlyn.org>
     * @license http://creativecommons.org/publicdomain/mark/1.0/ Public Domain
     */

    public static function xmlToArray($xml, $options = array())
    {
        $defaults = array(
            'namespaceRecursive' => false,  //setting to true will get xml doc namespaces recursively
            'removeNamespace' => false,     //set to true if you want to remove the namespace from resulting keys (recommend setting namespaceSeparator = '' when this is set to true)
            'namespaceSeparator' => ':',    //you may want this to be something other than a colon
            'attributePrefix' => '@',       //to distinguish between attributes and nodes with the same name
            'alwaysArray' => array(),       //array of xml tag names which should always become arrays
            'autoArray' => true,            //only create arrays for tags which appear more than once
            'textContent' => '$',           //key used for the text content of elements
            'autoText' => true,             //skip textContent key if node has no attributes or child nodes
            'keySearch' => false,           //optional search and replace on tag and attribute names
            'keyReplace' => false           //replace values for above search values (as passed to str_replace())
        );
        $options = array_merge($defaults, $options);
        $namespaces = $xml->getDocNamespaces($options['namespaceRecursive']);
        $namespaces[''] = null; //add base (empty) namespace

        //get attributes from all namespaces
        $attributesArray = array();
        foreach ($namespaces as $prefix => $namespace) {
            if ($options['removeNamespace']) {
                $prefix = '';
            }
            foreach ($xml->attributes($namespace) as $attributeName => $attribute) {
                //replace characters in attribute name
                if ($options['keySearch']) {
                    $attributeName =
                        str_replace($options['keySearch'], $options['keyReplace'], $attributeName);
                }
                $attributeKey = $options['attributePrefix']
                    . ($prefix ? $prefix . $options['namespaceSeparator'] : '')
                    . $attributeName;
                $attributesArray[$attributeKey] = (string)$attribute;
            }
        }

        //get child nodes from all namespaces
        $tagsArray = array();
        foreach ($namespaces as $prefix => $namespace) {
            if ($options['removeNamespace']) {
                $prefix = '';
            }

            foreach ($xml->children($namespace) as $childXml) {
                //recurse into child nodes
                $childArray = self::xmlToArray($childXml, $options);
                $childTagName = key($childArray);
                $childProperties = current($childArray);

                //replace characters in tag name
                if ($options['keySearch']) {
                    $childTagName =
                        str_replace($options['keySearch'], $options['keyReplace'], $childTagName);
                }

                //add namespace prefix, if any
                if ($prefix) {
                    $childTagName = $prefix . $options['namespaceSeparator'] . $childTagName;
                }

                if (!isset($tagsArray[$childTagName])) {
                    //only entry with this key
                    //test if tags of this type should always be arrays, no matter the element count
                    $tagsArray[$childTagName] =
                        in_array($childTagName, $options['alwaysArray'], true) || !$options['autoArray']
                            ? array($childProperties) : $childProperties;
                } elseif (
                    is_array($tagsArray[$childTagName]) && array_keys($tagsArray[$childTagName])
                    === range(0, count($tagsArray[$childTagName]) - 1)
                ) {
                    //key already exists and is integer indexed array
                    $tagsArray[$childTagName][] = $childProperties;
                } else {
                    //key exists so convert to integer indexed array with previous value in position 0
                    $tagsArray[$childTagName] = array($tagsArray[$childTagName], $childProperties);
                }
            }
        }

        //get text content of node
        $textContentArray = array();
        $plainText = trim((string)$xml);
        if ($plainText !== '') {
            $textContentArray[$options['textContent']] = $plainText;
        }

        //stick it all together
        $propertiesArray = !$options['autoText'] || $attributesArray || $tagsArray || ($plainText === '')
            ? array_merge($attributesArray, $tagsArray, $textContentArray) : $plainText;

        //return node as array
        return array(
            $xml->getName() => $propertiesArray
        );
    }

    public static function showData($param)
    {
        if (is_array($param))
            return "";
        return (string)$param;
    }

    /**
     * @return string
     */
    public static function getThreeMonthOld()
    {
        $currentDate = new DateTime();
        $currentDate->sub(new DateInterval('P3M'));
        return $currentDate->format('01.m.Y');
    }

    public static function getStringData($variable)
    {
        if (is_string($variable))
            return $variable;
        return "";
    }

    /**
     * @param string $type
     * @param string $message
     * @return void
     */
    public static function showMessage(string $type, string $message)
    {
        if (!Yii::$app->request->isConsoleRequest) {
            Yii::$app->session->setFlash($type, $message);
            return;
        }
        echo "Type {$type} : {$message}\n";
    }

    public static function sendExceptions(string $chatSlug, string $message)
    {
        if (!Yii::$app->request->isConsoleRequest) {
            $telegram = new TelegramHelper(false);
            $telegram->setChatIdBySlug($chatSlug);
            $telegram->sendMessage($message);
            return;
        }
//        echo "Chat {$chatSlug} : {$message}\n";
    }

    /**
     * @param $inputString
     * @return int
     * @throws \Exception
     */
    public static function yymmddHHMMSS2Time($inputString) // $inputString in the "yymmddHHMMSS" format
    {
        return DateTime::createFromFormat('ymdHis', $inputString)->getTimestamp();
    }

    /**
     * @param $amount
     * @return string
     */
    public static function tinier($amount)
    {
        $names = [' ming', ' million', ' milliard', ' triliard'];
        $init = 1000;
        $cnt = 0;
        while ($amount >= $init * 1000) {
            $cnt++;
            $init *= 1000;
            if ($cnt > 2)
                break;
        }
        return Utilities::print_format($amount / $init) . $names[$cnt];
    }

    /**
     * @param $amount
     * @return string
     */
    public static function tinier_no_name($amount)
    {
        $init = 1000000;
        $cnt = 0;
        while ($amount >= $init * 1000) {
            $cnt++;
            $init *= 1000;
            if ($cnt > 2)
                break;
        }
        return Utilities::print_format($amount / $init);
    }

    public static function convertSeconds($seconds)
    {
        $days = floor($seconds / (60 * 60 * 24));
        $hours = floor(($seconds % (60 * 60 * 24)) / (60 * 60));
        $minutes = floor(($seconds % (60 * 60)) / 60);
        $seconds = $seconds % 60;

        $result = '';
        if ($days > 0) {
            $result .= $days . ' ' . ($days > 1 ? Yii::t('app', 'days') : Yii::t('app', 'day')) . ' ';
        }
        if ($hours > 0) {
            $result .= $hours . ' ' . ($hours > 1 ? Yii::t('app', 'hours') : Yii::t('app', 'hour')) . ' ';
        }
        if ($minutes > 0) {
            $result .= $minutes . ' ' . ($minutes > 1 ? Yii::t('app', 'minutes') : Yii::t('app', 'minute')) . ' ';
        }
        $result .= $seconds . ' ' . ($seconds > 1 ? Yii::t('app', 'seconds') : Yii::t('app', 'second'));

        return rtrim($result);
    }

    public static function convertSecondsToBusinessHours($seconds)
    {
        $days = floor($seconds / (60 * 60 * 9));
        $hours = floor(($seconds % (60 * 60 * 9)) / (60 * 60));
        $minutes = floor(($seconds % (60 * 60)) / 60);
        $seconds = $seconds % 60;
        $result = '';
        $count = 0;

        if ($days > 0) {
            $count++;
            $result .= $days . ' ' . ($days > 1 ? Yii::t('app', 'days') : Yii::t('app', 'day')) . ' ';
        }
        if ($hours > 0) {
            $count++;
            $result .= $hours . ' ' . ($hours > 1 ? Yii::t('app', 'hours') : Yii::t('app', 'hour')) . ' ';
        }
        if ($minutes > 0 && $count < 2) {
            $count++;
            $result .= $minutes . ' ' . ($minutes > 1 ? Yii::t('app', 'minutes') : Yii::t('app', 'minute')) . ' ';
        }
        if ($count < 2) {
            $result .= $seconds . ' ' . ($seconds > 1 ? Yii::t('app', 'seconds') : Yii::t('app', 'second'));
        }

        return rtrim($result);
    }

    public static function generateOTP($length)
    {
        $otp = '';
        for ($i = 0; $i < 6; $i++) {
            $otp .= mt_rand(0, 9);
        }
        return $otp;
    }

    public static function maskThePhoneNumber($phone_number)
    {
        $regex = '/(\+998)(\d{3})\d{3}(\d{2})/';
        return preg_replace($regex, '$1$2***$3', $phone_number);
    }

    public static function setQueryMarket(ActiveQuery $query, $market_id, $table_name = null): ActiveQuery
    {
        $field = 'market_id';
        if ($table_name != null)
            $field = $table_name . $field;
        switch ($market_id) {
            case -1:
                return $query->andWhere(['in', $field, Market::tolmasMarkets()]);
            case -2:
                return $query->andWhere(['in', $field, Market::ownerCashMarket(User::TOLMASBEK)]);
            case -3:
                return $query->andWhere(['in', $field, Market::farxodMarkets()]);
            case -4:
                return $query->andWhere(['in', $field, Market::ownerCashMarket(User::FARXOD_GIJDUVON)]);
            default:
                return $query;
        }
    }

    public static function sendLogs($logs)
    {
        $telegram = new TelegramHelper();
        $telegram->setChatIdBySlug();
        $telegram->sendMessage($logs);
    }

    private static function random_color_part()
    {
        return str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT);
    }

    public static function random_color()
    {
        return self::random_color_part() . self::random_color_part() . self::random_color_part();
    }

    public static function betweenCondition($element, $left, $right, $salt = null)
    {
        if ($salt) {
            $left = $salt - $left;
            $right = $salt - $right;
        }
        return $left <= $element && $element <= $right;
    }

    public static function allowedTags()
    {
        return ["<br>", "<i></i>", "<em></em>", "<b></b>", "<p></p>", "<strong></strong>"];
    }

    public static function logConfigs()
    {
        return [
            [
                'class' => 'yii\log\FileTarget',
                'levels' => ['error'],
                'logFile' => '@app/runtime/logs/error.log',
                'logVars' => [],
                'categories' => ['application'],
            ],
            [
                'class' => 'yii\log\FileTarget',
                'levels' => ['warning'],
                'logFile' => '@app/runtime/logs/warning.log',
                'logVars' => [],
                'categories' => ['application'],
            ],
            [
                'class' => 'yii\log\FileTarget',
                'levels' => ['info'],
                'logFile' => '@app/runtime/logs/info.log',
                'logVars' => [],
                'categories' => ['application'],
            ],
            [
                'class' => 'yii\log\FileTarget',
                'levels' => ['trace'],
                'logFile' => '@app/runtime/logs/trace.log',
                'logVars' => [],
                'categories' => ['application'],
            ],
        ];
    }

    public static function getColorByHash(string $key, string $hash)
    {
        return Yii::$app->cache->getOrSet($key, function () use ($hash) {
            return self::getColorForDevice($hash);
        }, self::A_YEAR);

    }

    public static function getColorForDevice($deviceName)
    {
        $index = crc32($deviceName) % 100; // Adjust the modulus to generate a higher range if needed
        return self::generateLightColor($index);
    }

    private static function generateLightColor($index)
    {
        srand($index);
        $r = rand(200, 255);
        $g = rand(200, 255);
        $b = rand(200, 255);

        return sprintf('#%02X%02X%02X', $r, $g, $b);
    }

    public static function getRemainingDaysToBirthday($birthTimestamp) {
        $today = strtotime('today');

        $currentYear = date('Y');
        $birthday = new DateTime(date('Y-m-d', $birthTimestamp));

        $birthday->setDate($currentYear, $birthday->format('m'), $birthday->format('d'));

        if ($today > $birthday->getTimestamp()) {
            $birthday->modify('+1 year');
        }

        $nextBirthdayTimestamp = $birthday->getTimestamp();
        $daysRemaining = ($nextBirthdayTimestamp - $today) / 86400;

        if (ceil($daysRemaining) == 0 && date('Y-m-d', $today) == $birthday->format('Y-m-d')) {
            return 0;
        }

        return floor($daysRemaining);
    }

    public static function charLimiter($text, $limit) {
        $words = explode(' ', strip_tags($text));
        $words = array_filter($words);
        $firstWords = array_slice($words, 0, $limit);
        return implode(' ', $firstWords) . (count($words) > $limit ? '...' : '');
    }

}
