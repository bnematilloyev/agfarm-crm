<?php


namespace common\models\constants;


use Yii;

class TelegramChatType
{
    const TYPE_BOOK = 1;
    const TYPE_COMPLAINT = 2;

    /**
     * @return array
     */
    public static function getList()
    {
        return [
            self::TYPE_BOOK => self::getString(self::TYPE_BOOK),
            self::TYPE_COMPLAINT => self::getString(self::TYPE_COMPLAINT),
        ];
    }

    /**
     * @param $role
     * @return string
     */
    public static function getString($role)
    {
        if ($role == self::TYPE_BOOK) return Yii::t('app', 'Buyurtma berish');
        if ($role == self::TYPE_COMPLAINT) return Yii::t('app', 'Shikoyat');
        return Yii::t('app', 'Unknown');
    }
}