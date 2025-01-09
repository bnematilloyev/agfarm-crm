<?php


namespace common\models\constants;


use Yii;

class UserRole
{
    const ROLE_EMPLOYEE = 0;
    const ROLE_ADMIN = 20;
    const ROLE_SUPER_ADMIN = 30;
    const ROLE_DEVELOPER = 90;
    const ROLE_CREATOR = 100;
    const ROLE_GUEST = -1;

    public static function getString($role)
    {
        if ($role == self::ROLE_GUEST) return Yii::t('app', "Guest");
        if ($role == self::ROLE_EMPLOYEE) return Yii::t('app', "Employee");
        if ($role == self::ROLE_ADMIN) return Yii::t('app', "Manager");
        if ($role == self::ROLE_SUPER_ADMIN) return Yii::t('app', "Administrator");
        if ($role == self::ROLE_DEVELOPER) return Yii::t('app', "Developer");
        if ($role == self::ROLE_CREATOR) return Yii::t('app', "Creator");
        return \Yii::t('app', "Unknown");
    }

    public static function getList()
    {

        if (\Yii::$app->user->identity->is_creator)
            return [
                self::ROLE_GUEST => self::getString(self::ROLE_GUEST),
                self::ROLE_EMPLOYEE => self::getString(self::ROLE_EMPLOYEE),
                self::ROLE_ADMIN => self::getString(self::ROLE_ADMIN),
                self::ROLE_SUPER_ADMIN => self::getString(self::ROLE_SUPER_ADMIN),
                self::ROLE_DEVELOPER => self::getString(self::ROLE_DEVELOPER),
                self::ROLE_CREATOR => self::getString(self::ROLE_CREATOR)
            ];

        return [
            self::ROLE_GUEST => self::getString(self::ROLE_GUEST),
            self::ROLE_EMPLOYEE => self::getString(self::ROLE_EMPLOYEE),
            self::ROLE_ADMIN => self::getString(self::ROLE_ADMIN),
        ];
    }

    public static function getSystem()
    {
        return "https://crm.phone-collection.uz";
    }

    /**
     * @return array
     */
    public static function positionList4Api(): array
    {
        $data = [];
        foreach (self::getList() as $key => $item) {
            $data[] = [
                'id' => $key,
                'name' => $item,
            ];
        }
        return $data;
    }

}