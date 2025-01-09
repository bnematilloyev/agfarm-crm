<?php


namespace common\models\constants;


use Yii;

class ProjectType
{
    const ALL = 0;
    const CRM = 10;
    const TEAM = 20;
    const MERCHANT = 30;
    const FINANCE = 40;


    public static function getString($role)
    {
        if ($role == self::ALL) return Yii::t('app', "Hammasiga");
        if ($role == self::CRM) return Yii::t('app', "CRM");
        if ($role == self::TEAM) return Yii::t('app', "TEAM");
        if ($role == self::MERCHANT) return Yii::t('app', "MERCHANT");
        if ($role == self::FINANCE) return Yii::t('app', "FINANCE");
        return \Yii::t('app', "Unknown");
    }

    public static function getList()
    {
        return [
            self::ALL => self::getString(self::ALL),
            self::CRM => self::getString(self::CRM),
            self::TEAM => self::getString(self::TEAM),
            self::MERCHANT => self::getString(self::MERCHANT),
            self::FINANCE => self::getString(self::FINANCE),
        ];
    }
}