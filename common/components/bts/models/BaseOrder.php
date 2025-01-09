<?php
/**
 * Created by PhpStorm.
 * User: Nuriddin Kamardinov
 * Date: 11/09/2021
 * Time: 13:27
 */

namespace common\components\bts\models;

use common\helpers\Utilities;
use common\models\Order;
use yii\base\Model;

class BaseOrder extends Model
{
    public $senderCityId;
    public $senderAddress;
    public $senderReal;
    public $senderPhone;
    public $weight;
    public $packageId;
    public $postTypeId;
    public $receiver;
    public $receiverAddress;
    public $receiverCityId;
    public $volume;
    public $urgent;
    public $takePhoto;
    public $is_test;
    public $senderSign;
    public $receiverSign;
    public $piece;
    public $senderDate;
    public $receiverDate;
    public $receiverPhone;
    public $receiverPhone1;
    public $senderDelivery;
    public $receiverDelivery;
    public $bringBackMoney;
    public $back_money;
    public $clientId;

    public function __construct(Order $order,
                                $weight,
                                $postTypeId,
                                $cost = 0,
                                $config = [])
    {
        $this->senderCityId = 198;
        $this->senderAddress = 'Ташкентская область, Пскенткий район Пскент улица Бобур 65д';
        $this->senderReal = 'ООО «ASAXIY BOOKS»';
        $this->senderPhone = '+998 90 0291289';
        $this->weight = $weight;
        $this->packageId = 8;
        $this->postTypeId = $postTypeId;
        $this->receiver = $order->full_name;
        $this->receiverAddress = $order->address;
        $this->receiverCityId = $order->city->bts_id;
        $this->volume = 0; //todo ask
        $this->urgent = 0; //todo ask
        $this->takePhoto = 0; // todo ask
        $this->is_test = Utilities::isLocal() ? 1 : 0;
        $this->piece = 1; //todo ask
        $this->receiverPhone = $order->phone;
        $this->receiverPhone1 = $order->second_phone;
        $this->senderDelivery = 0;
        $this->receiverDelivery = 1;
        $this->bringBackMoney = ($cost > 0) ? 1 : 0;
        $this->back_money = $cost;
        $this->clientId = $order->id;
        parent::__construct($config);
    }
}