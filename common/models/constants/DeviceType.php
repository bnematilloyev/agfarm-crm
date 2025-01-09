<?php


namespace common\models\constants;


class DeviceType
{
    const STATUS_DESKTOP = 0;
    const STATUS_MOBILE = 1;

    public static function getString($role)
    {
        if ($role == self::STATUS_DESKTOP) return \Yii::t('app', "Desktop");
        if ($role == self::STATUS_MOBILE) return \Yii::t('app', "Mobile");
        return \Yii::t('app', 'Unknown');
    }

    public static function getList()
    {
        return [
            self::STATUS_DESKTOP => self::getString(self::STATUS_DESKTOP),
            self::STATUS_MOBILE => self::getString(self::STATUS_MOBILE),
        ];
    }

    public static function detectMobile($device_name)
    {
        return str_contains($device_name, "Android") || str_contains($device_name, "iPhone OS");
    }
}