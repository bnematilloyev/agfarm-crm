<?php

namespace common\models\constants;

class Currency
{
    const SUM = 1;
    const USD = 2;
    const RUB = 3;

    public static function getArray()
    {
        return [
            self::SUM => 'SUM',
            self::USD => 'USD',
            self::RUB => 'RUB',
        ];
    }

    public static function getStringValue($currency)
    {
        if ($currency == self::SUM) {
            return 'UZS';
        }

        if ($currency == self::USD) {
            return 'USD';
        }

        if ($currency == self::RUB) {
            return 'RUB';
        }
    }
}
