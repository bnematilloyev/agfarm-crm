<?php
/**
 * Created by PhpStorm.
 * User: Nuriddin Kamardinov
 * Date: 11/09/2021
 * Time: 13:24
 */

namespace common\components\bts;

use common\components\bts\models\BaseOrder;
use Exception;

class BtsComponent
{
    private const URL = 'http://api.bts.uz:8080/index.php?r=v1/';
    public $token;

    public function __construct()
    {

    }

    public function createOrder(BaseOrder $order)
    {
        $response = $this->runUrl('order/add', $order, 'POST');

        if (isset($response['orderId'])) {
            return $response['orderId'];
        } else {
            throw new Exception(json_encode($response));
        }

    }

    public function getOrder($bts_id)
    {
        $response = $this->runUrl('order/detail&id=' . $bts_id, null, 'GET');

        return $response;
    }

    private function runUrl($method, $fields = [], $type = 'GET')
    {
        $headers = array(
            "Content-Type: application/json",
            "Authorization: Bearer $this->token"
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, self::URL . $method);
        switch ($type) {
            case 'POST':
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
                break;
            case 'PUT':
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $type);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
                break;
            case 'GET':
            case 'DELETE':
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $type);
                break;
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        return json_decode($result, true);
    }
}