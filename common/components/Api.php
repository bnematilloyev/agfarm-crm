<?php

namespace common\components;

use common\models\Company;
use Yii;
use yii\base\Component;

/**
 * Class for common API functions
 */
class Api extends Component
{
    /**
     * @param $data
     * @param $additional_info
     * @return array
     */
    public function sendSuccessResponse($data = false, $additional_info = false)
    {
        $this->setHeader(200);

        $response = [];
        $response['status'] = 1;

        if ($data !== false)
            $response['data'] = $data;

        if ($additional_info) {
            $response = array_merge($response, $additional_info);
        }
        return $response;
    }

    /**
     * @param $data
     * @param $additional_info
     * @return array
     */
    public function sendUniredOKResponse()
    {
        $this->setHeader(200);
        return [
            'success' => true,
            'message' => 'OK'
        ];
    }

    /**
     * @param $data
     * @param $additional_info
     * @return array
     */
    public function uniredGetResponse($result, $code = 0, $message = 'SUCCESS', $success = true)
    {
        $this->setHeader(200);
        return [
            'success' => $success,
            'code' => $code,
            'message' => $message,
            'result' => $result
        ];
    }

    public function genereateGenesisResponseData($data)
    {
        $this->setHeader(200);
        return $data;
    }

    /**
     * @param $message
     * @param $additional_info
     * @return array
     */
    public function sendSuccessMessage($message = false, $additional_info = false)
    {
        $this->setHeader(200);

        $response = [];
        $response['status'] = 1;

        if ($message !== false)
            $response['message'] = $message;

        if ($additional_info) {
            $response = array_merge($response, $additional_info);
        }
        return $response;
    }

    /**
     * @param $status
     * @return void
     */
    protected function setHeader($status)
    {

        $text = $this->_getStatusCodeMessage($status);

        Yii::$app->response->setStatusCode($status, $text);

        $status_header = 'HTTP/1.1 ' . $status . ' ' . $text;
        $content_type = "application/json; charset=utf-8";


        header($status_header);
        header('Content-type: ' . $content_type);
        header('X-Powered-By: ' . "Asaxiy IT <www.asaxiy.uz>");
        header('Access-Control-Allow-Origin:*');

    }

    protected function _getStatusCodeMessage($status)
    {
        // these could be stored in a .ini file and loaded
        // via parse_ini_file()... however, this will suffice
        // for an example
        $codes = array(
            200 => 'OK',
            400 => 'Bad Request',
            401 => 'Unauthorized',
            402 => 'Payment Required',
            403 => 'Forbidden',
            404 => 'Not Found',
            500 => 'Internal Server Error',
            501 => 'Not Implemented',
        );
        return (isset($codes[$status])) ? $codes[$status] : '';
    }

    public function refreshAccesstoken($token)
    {
        $access_token = Company::findOne(['key' => $token]);
        if ($access_token) {
            return $access_token;
        } else {
            Yii::$app->api->sendFailedResponse("Invalid Access token2");
        }
    }

    /**
     * @param $message
     * @return array
     */
    public function sendFailedResponse($message, $status_code = 200, $additional_info = false)
    {
        $this->setHeader($status_code);

        $response = array('status' => 0, 'message' => $message);
        if ($additional_info) $response = array_merge($response, $additional_info);

        return $response;
    }

}
