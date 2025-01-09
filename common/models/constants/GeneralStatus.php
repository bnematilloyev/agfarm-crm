<?php


namespace common\models\constants;


class GeneralStatus
{
    const STATUS_DISMISSED = -1; // Bo'shatilgan
    const STATUS_DELETED = 0;
    const STATUS_PENDING = 1;
    const STATUS_NEW = 5;
    const STATUS_ACTIVE = 10;
    const STATUS_INACTIVE = 20;
    const STATUS_PUBLISHED = 30;

    public static function getString($role)
    {
        if ($role == self::STATUS_INACTIVE) return \Yii::t('app', "In active");
        if ($role == self::STATUS_ACTIVE) return \Yii::t('app', "Active");
        if ($role == self::STATUS_PUBLISHED) return \Yii::t('app', "Active");
        if ($role == self::STATUS_PENDING) return \Yii::t('app', "Pending");
        if ($role == self::STATUS_DELETED) return \Yii::t('app', "Deleted");
        if ($role == self::STATUS_NEW) return \Yii::t('app', "New");
        if ($role == self::STATUS_DISMISSED) return \Yii::t('app', "Dismissed");

        return "Noma'lum";
    }

    public static function getList()
    {
        return [
            self::STATUS_ACTIVE => self::getString(self::STATUS_ACTIVE),
            self::STATUS_INACTIVE => self::getString(self::STATUS_INACTIVE),
        ];
    }
}