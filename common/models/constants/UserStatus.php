<?php


namespace common\models\constants;


class UserStatus
{
    const STATUS_DELETED = -1;
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 10;

    public static function getString($role)
    {
        if ($role == self::STATUS_ACTIVE) return \Yii::t('app', "Active");
        if ($role == self::STATUS_INACTIVE) return \Yii::t('app', "In active");
        if ($role == self::STATUS_DELETED) return \Yii::t('app', "Deleted");
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