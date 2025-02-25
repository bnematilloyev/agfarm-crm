<?php

namespace common\models\constants;

use Yii;

class ProductState
{
    // при модерации
    public const WAITING = 0;
    // нет в наличии
    public const NOT_AVAILABLE = 1;
    // есть в наличии
    public const AVAILABLE = 2;
    //предзаказ
    public const PRE_ORDER = 3;

    /**
     * @param int $state
     * @return string
     */
    public static function getString(int $state = null)
    {
        switch ($state) {
            case self::WAITING:
                return Yii::t('app', 'Ожидание');
            case self::AVAILABLE:
                return Yii::t('app', 'Есть в наличии');
            case self::PRE_ORDER:
                return Yii::t('app', 'Предзаказ');
            case self::NOT_AVAILABLE:
            default:
                return Yii::t('app', 'Нет в наличии');
        }
    }

    /**
     * @return array
     */
    public static function getList()
    {
        return [
            self::WAITING => self::getString(self::WAITING),
            self::NOT_AVAILABLE => self::getString(self::NOT_AVAILABLE),
            self::AVAILABLE => self::getString(self::AVAILABLE),
            self::PRE_ORDER => self::getString(self::PRE_ORDER),
        ];
    }

    public static function getStringWithQuantity(int $state = null, $quantity = '')
    {
        switch ($state) {
            case self::WAITING:
                return Yii::t('app', 'Ожидание');
            case self::AVAILABLE:
                if (is_numeric($quantity) && $quantity > 0) {
                    if ($quantity > 200)
                        $quantity = 200;
                    return Yii::t('app', 'В наличии: {quantity} шт', ['quantity' => $quantity]);
                }
                return Yii::t('app', 'В наличии');
            case self::PRE_ORDER:
                if (is_numeric($quantity)) {
                    return Yii::t('app', 'Нет в наличии');
                }
                return Yii::t('app', 'Предзаказ');
            case self::NOT_AVAILABLE:
            default:
                return Yii::t('app', 'Нет в наличии');
        }
    }
}
