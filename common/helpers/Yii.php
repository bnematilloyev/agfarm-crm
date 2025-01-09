<?php
/**
 * Created by PhpStorm.
 * User: Husayn Hasanov
 * Date: 4/20/19
 * Time: 3:14 PM
 */

use common\components\Api;
use common\components\bts\BtsComponent;
use common\models\Admin;
use common\models\User;
use daxslab\thumbnailer\Thumbnailer;
use frontend\components\InfoComponent;
use frontend\services\CartService;
use frontend\services\UserStoreService;

use yii\BaseYii;
use yii\caching\CacheInterface;
use yii\db\Connection;

/**
 * Yii bootstrap file.
 * Used for enhanced IDE code autocompletion.
 */
class Yii extends BaseYii
{
    /**
     * @var BaseApplication|WebApplication|ConsoleApplication the application instance
     */
    public static $app;
}

/**
 * Class BaseApplication
 * Used for properties that are identical for both WebApplication and ConsoleApplication
 *
 * @property Api $api
 * @property CacheInterface $smsCache
 * @property CacheInterface $uniCache
 * @property CacheInterface $activityCache
 * @property \common\components\TelegramNotify $telegramNotify
 * @property Connection $db_asaxiy
 * @property BtsComponent $bts
 * @property \common\services\JwtService $jwtService
 */
abstract class BaseApplication extends yii\base\Application
{
}

/**
 * Class WebApplication
 * Include only Web application related components here
 * @property User $user The user component. This property is read-only. Extended component.
 */
class WebApplication extends yii\web\Application
{
}

/**
 * Class ConsoleApplication
 * Include only Console application related components here
 *
 */
class ConsoleApplication extends yii\console\Application
{
}