<?php

namespace common\models\constants;

use Yii;
class ProductConstants
{
    public const STATUS_DELETED = -1;
    public const STATUS_WAITING = 0;
    public const STATUS_ACTIVE = 10;
    public const STATUS_ARCHIVED = 5;
    public static function getString(int $status)
    {
        switch ($status) {
            case self::STATUS_DELETED:
                return Yii::t('app', 'Удалено');
            case self::STATUS_WAITING:
                return Yii::t('app', 'Отключено');
            case self::STATUS_ACTIVE:
                return Yii::t('app', 'Включено');
            case self::STATUS_ARCHIVED:
                return Yii::t('app', 'Архивировано');
        }

        return Yii::t('Unknown');
    }

    public static function getList()
    {
        return [
            self::STATUS_DELETED => self::getString(self::STATUS_DELETED),
            self::STATUS_WAITING => self::getString(self::STATUS_WAITING),
            self::STATUS_ACTIVE => self::getString(self::STATUS_ACTIVE),
            self::STATUS_ARCHIVED => self::getString(self::STATUS_ARCHIVED),
        ];
    }

    public static function getStatusOnAndOff()
    {
        return [
            self::STATUS_ACTIVE => self::getString(self::STATUS_ACTIVE),
            self::STATUS_WAITING => self::getString(self::STATUS_WAITING),
            self::STATUS_ARCHIVED => self::getString(self::STATUS_ARCHIVED),
        ];
    }
}