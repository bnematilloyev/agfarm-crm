<?php

namespace common\services;

use common\helpers\Utilities;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\StreamInterface;

class HaticoService
{
    private const API_URL = "https://api.hatico.xyz";
    private const ORDER_URL = "https://lawyer.abrand.uz/show/order?id=";
    private const CUSTOMER_MY_ID_SIGNATURE_URL = "https://api.abrand.uz/v1/customer/my-id-signature?id=";
    private const SCORING_URL = "https://lawyer.abrand.uz/show/scoring?id=";
    private const DAILY_REPORT = "https://lawyer.abrand.uz/show/daily?id=";
    private const DAILY_REPORT_CUSTOMER = "https://lawyer.abrand.uz/show/daily-customer-order";
    private const DAILY_REPORT_LAWYER_DASHBOARD = "https://lawyer.abrand.uz/show/dashboard";
    private const DAILY_TRANSACTION = "https://lawyer.abrand.uz/show/transaction-show?token=lawyer-abrand-uz–show-transaction-show-32rfe34v342";
    private const KATM_SCORING = "https://lawyer.abrand.uz/show/katm-scoring?id=";
    private const MIB_SCORING = "https://lawyer.abrand.uz/show/mib?passport=";
//    private const KATM_SCORING = "http://lawyer.mtd.local/show/katm-scoring?id=";

    /**
     * @param $id
     * @return StreamInterface|null
     */
    public function orderIntoImage($id)
    {
        $options = [
            "width" => 1600,
            "height" => 1600,
            "scale" => 2
        ];
        return $this->convertUrl(self::ORDER_URL . $id, $options);
    }

    /**
     * @param $id
     * @return StreamInterface|null
     */
    public function getDailyReport($id)
    {
        $options = [
            "width" => 800,
            "height" => 600,
            "scale" => 2
        ];
        return $this->convertUrl(self::DAILY_REPORT . $id, $options);
    }

    /**
     * @param $id
     * @return StreamInterface|null
     */
    public function getDailyReportCustomer()
    {
        $options = [
            "width" => 1200,
            "height" => 1200,
            "scale" => 2
        ];
        return $this->convertUrl(self::DAILY_REPORT_CUSTOMER, $options);
    }

    public function getDailyLawyerDashboard()
    {
        $options = [
            "width" => 1300,
            "height" => 800,
            "scale" => 2
        ];
        return $this->convertUrl(self::DAILY_REPORT_LAWYER_DASHBOARD, $options);
    }

    /**
     * @param $id
     * @return StreamInterface|null
     */
    public function getDailyTransaction()
    {
        $options = [
            "width" => 1200,
            "height" => 1200,
            "scale" => 2
        ];
        return $this->convertUrl(self::DAILY_TRANSACTION, $options);
    }

    /**
     * @param $id
     * @return StreamInterface|null
     */
    public function getMib($passport)
    {
        $options = [
            "width" => 600,
            "height" => 50,
            "scale" => 2
        ];
        return $this->convertUrl(self::MIB_SCORING . $passport, $options);
    }

    /**
     * @param $id
     * @return StreamInterface|null
     */
    public function scoringIntoImage($id)
    {
        $options = [
            "width" => 1600,
            "height" => 1600,
            "scale" => 2
        ];
        return $this->convertUrl(self::SCORING_URL . $id, $options);
    }

    /**
     * @param $id
     * @return StreamInterface|null
     */
    public function katmScoringIntoImage($id)
    {
        $options = [
            "width" => 1200,
            "height" => 1400,
            "scale" => 2
        ];
        return $this->convertUrl(self::KATM_SCORING . $id, $options);
    }

    /**
     * @param $customerId
     * @return StreamInterface|null
     */
    public function myIdSignatureIntoImage($customerId)
    {
        $options = [
            "width" => 1200,
            "height" => 600,
            "scale" => 2
        ];
        return $this->convertUrl(self::CUSTOMER_MY_ID_SIGNATURE_URL . $customerId, $options);
    }

    /**
     * @param string $html
     * @param array $options = [
     *     'width' => 600,
     *     'height' => 400,
     *     'scale' => 1.5
     * ]
     * @return StreamInterface|null
     */
    private function convertHtml(string $html, array $options = []): ?StreamInterface
    {
        $client = new Client(['timeout' => 100]);

        try {
            $response = $client->request('POST', self::API_URL . '/convert', [
                'multipart' => [
                    ['name' => 'html', 'contents' => $html],
                    ['name' => 'options', 'contents' => json_encode($options)]
                ]
            ]);
        } catch (GuzzleException $e) {
            return null;
        }

        return $response->getBody();
    }

    /**
     * @param string $url
     * @param array $options = [
     *     'width' => 600,
     *     'height' => 400,
     *     'scale' => 1.5
     * ]
     * @return StreamInterface|null
     */
    private function convertUrl(string $url, array $options = []): ?StreamInterface
    {
        $client = new Client(['timeout' => 100]);
        $key = "authorization=" . Utilities::generateSecurityKey(300);
        $url .= (strpos($url, '?') === false ? '?' : '&') . $key;
        try {
            $response = $client->request('POST', self::API_URL . "/convert", [
                'multipart' => [
                    ['name' => 'url', 'contents' => $url],
                    ['name' => 'options', 'contents' => json_encode($options)]
                ]
            ]);
        } catch (GuzzleException $e) {
            return null;
        }

        return $response->getBody();
    }
}
