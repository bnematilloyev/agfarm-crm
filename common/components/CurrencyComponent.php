<?php
/**
 * Created by PhpStorm.
 * User: Husayn_Hasanov
 * Date: 12/21/18
 * Time: 14:03
 */

namespace common\components;

use yii\caching\TagDependency;

class CurrencyComponent
{
    private $cache;

    public function __construct($config = [])
    {
        $this->cache = \Yii::$app->currencyCache;
    }

    public function get($code){
        $result = $this->cache->getOrSet(['currency', 'name' => $code], function () use ($code) {
            $json_text = file_get_contents('https://nbu.uz/exchange-rates/json/');
            $json = json_decode($json_text);
            if ($json === null && json_last_error() !== JSON_ERROR_NONE) {
                $json_text = file_get_contents(\Yii::getAlias('@assets/nbu.json'));
                $json = json_decode($json_text);
            }
            file_put_contents(\Yii::getAlias('@assets/nbu.json'), $json_text);
            foreach($json as $item):
                if ($item->code == $code)
                    return $item->nbu_cell_price;
            endforeach;
            return 0;
        }, null, new TagDependency(['tags' => ['currency']]));
        return $result;
    }

    public function getUSD(){
        return $this->get('USD');
    }
}