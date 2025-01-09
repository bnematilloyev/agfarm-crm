<?php


namespace common\helpers;

use common\models\Customer;
use common\models\TelegramMessage;

/**
 * This is the model class for table "SMS".
 *
 * @property string $token
 * @property string $chat_id
 *
 */
class TelegramWebHook
{
    const TELEGRAM_API_URL = "https://api.telegram.org/bot";
    const TELEGRAM_URL = "https://api.telegram.org/";
    const MUROBAHA_BOT_TOKEN = "5129961388:AAEximR_BvYj-_hKHXjbqNk_JCO7DBs72Mo";
    const BOT_TOKEN = "5658932610:AAER9dgDLjlwUbeo8h0ueUbRMmpJwyj4qTQ";
    private $token;
    private $chat_id = 866653168;


    public function __construct()
    {
        $this->setToken(self::BOT_TOKEN);
    }

    /**
     * @param $text
     * @return bool
     */
    public function sendMessage($text)
    {
        return $this->cURL(['chat_id' => $this->chat_id, "text" => $text, "parse_mode" => "html"]);
    }

    /**
     * @param $text
     * @return bool
     */
    public function sendMessageInline($text)
    {
        return $this->cURL(['chat_id' => $this->chat_id, "text" => $text, "parse_mode" => "html",
            'reply_markup' => json_encode([
                'inline_keyboard' => [[[
                    'text' => '🔎 Mahsulot qidirish',
                    'switch_inline_query_current_chat' => ""
                ]]]
            ])]);
    }

    private function prepareAnswerResults($products)
    {
        $result = [];
        foreach ($products as $product) {
            $result[] = $this->prepareAnswerResult($product);
        }
        return $result;
    }

    private function prepareAnswerResult($product)
    {
        return [
            'type' => 'article',
            'id' => base64_encode($product['id']),
            'title' => $product['name'],
            'description' => "Narxi: " . $product['price'],
            'thumb_url' => $product['image'],
            'input_message_content' => [
                'parse_mode' => 'html',
                'message_text' => "<a href='https://asaxiy.uz/product/" . $product['slug'] . "'>" . $product['name'] . "\nNarxi: " . $product['price'] . "\nLink: https://asaxiy.uz/product/" . $product['slug'] . "</a>"
            ],
            'reply_markup' => [
                'inline_keyboard' => [
                    [['text' => 'Mahsulotga o\'tish', 'url' => "https://asaxiy.uz/product/" . $product['slug']]],
                    [['text' => 'Yana qidirish', 'switch_inline_query_current_chat' => ""]]
                ]
            ]

        ];
    }

    /**
     * @param $text
     * @return bool
     */
    public function answerInlineMessage($query_id, $products, $next_offset = 1)
    {
//        $this->sendMessageToChatId(json_encode($this->prepareAnswerResults($products)), 866653168);
        $response = $this->cURL(
            [
                "inline_query_id" => $query_id,
                "cache_time" => 1,
                "parse_mode" => "html",
                "next_offset" => $next_offset,
                'results' => json_encode($this->prepareAnswerResults($products))], "answerInlineQuery");
//        $this->sendMessageToChatId(json_encode($response), 866653168);
        return $response;
    }

    public function getChatMember($tg_id, $chat_id)
    {
        $parameters = [
            "user_id" => $tg_id,
            "chat_id" => $chat_id,
        ];
        return $this->getURL($parameters, "getChatMember");
    }


    private function fakeData()
    {
        return [
            [
                'type' => 'article',
                'id' => base64_encode(1),
                'title' => "Чехол Silicone cover для Samsung Galaxy A31, белый",
                'description' => "Narxi: 30 000.00 so`m",
                'thumb_url' => "https://assets.asaxiy.uz/product/main_image/mobile//608fd9a0bceb0.jpg.webp",
                'input_message_content' => [
                    'parse_mode' => 'html',
                    'message_text' => "<a href='https://asaxiy.uz/product/chehol-silicone-cover-dlya-samsung-galaxy-a31-belyj'>Чехол Silicone cover для Samsung Galaxy A31, белый\nNarxi: 30 000.00 so`m\n</a>"
                ],
                'reply_markup' => [
                    'inline_keyboard' => [
                        [['text' => 'Mahsulotga o\'tish', 'url' => "https://asaxiy.uz/product/chehol-silicone-cover-dlya-samsung-galaxy-a31-belyj"]],
                        [['text' => 'Yana qidirish', 'switch_inline_query_current_chat' => ""]]
                    ]
                ]
            ],
        ];
    }

    /**
     * @param TelegramMessage $user
     * @return void
     */
    public function sendNewOrder(TelegramMessage $user)
    {

        $this->cUrlOrder([
            "chat_id" => '-1001655423687',
            "media" => json_encode([
                ["type" => "photo", "media" => "https:" . $user->pasimg1],
                ["type" => "photo", "media" => "https:" . $user->pasimg2],
                ["type" => "photo", "media" => "https:" . $user->pasimg3,
                    "caption" => "Yangi xaridor!\nPINFL: " . $user->pinfl . "\nPassport: " . $user->passer . $user->pasnum . "\nFIO: " . $user->full_name . "\nManzili: " . $user->full_address,
                    "parse_mode" => "html"
                ]
            ]),
        ]);
    }

    /**
     * @param $customer_url_text
     * @param TelegramMessage $user
     * @param $text
     * @return bool
     */
    public function sendCustomerHopes($customer_url_text, $text)
    {
        return $this->cUrlOrder(['chat_id' => '-1001655423687', "text" => "\nXaridor: " . $customer_url_text . "\nMurojaat: " . $text, "parse_mode" => "html"], "sendMessage");
    }

    public function setToken($bot_token)
    {
        $this->token = $bot_token;
    }

    /**
     * @param $text
     * @return bool
     */
    public function sendMessageByButton($text, $keyboard)
    {
        return $this->cURL(['chat_id' => $this->chat_id, "text" => $text, "parse_mode" => "html",
            "reply_markup" => json_encode([
                "resize_keyboard" => true,
                "one_time_keyboard" => true,
                "keyboard" => $keyboard
            ])
        ]);
    }

    /**
     * @param $text
     * @return bool
     */
    public function sendMessageByReply($text, $reply)
    {
        return $this->cURL(['chat_id' => $this->chat_id, "text" => $text, "parse_mode" => "html", "reply_markup" => $reply]);
    }

    /**
     * @param $text
     * @param $chat_id
     * @return bool
     */
    public function sendMessageToChatId($text, $chat_id)
    {
        return $this->cURL(['chat_id' => $chat_id, "text" => $text, "parse_mode" => "html"]);
    }

    /**
     * @param $chat_id
     * @return void
     */
    public function setChatId($chat_id)
    {
        $this->chat_id = $chat_id;
    }

    /**
     * @param $file
     * @param string $text
     * @return bool
     */
    public function sendFile($file, $text = "", $type = 'document', $sender = "sendDocument")
    {
        return $this->cURL([$type => $file, 'chat_id' => $this->chat_id, 'caption' => $text], $sender);
    }


    /**
     * @param $file
     * @param string $text
     * @return bool
     */
    public function deleteMessage($message_id)
    {
        return $this->cURL(['chat_id' => $this->chat_id, 'message_id' => $message_id], "deleteMessage");
    }

    public function downloadFile($file_path)
    {
        $random_name = uniqid("customer-image-") . time();
        $file_dir = \Yii::getAlias('@assets/customer/telegram/');
        $file_name = $random_name . str_replace("/", "-", $file_path);
        file_put_contents($file_dir . $file_name, file_get_contents(self::TELEGRAM_URL . "file/bot" . $this->token . "/" . $file_path));
        return \Yii::getAlias('@assets_url/customer/telegram/') . $file_name;
    }

    private function open_file($filename, $new_filename)
    {
        $handle = fopen($filename, "rb");
        $contents = fread($handle, filesize($filename));
        file_put_contents($new_filename, $contents);
        fclose($handle);
    }

    /**
     * @param $file
     * @param string $text
     * @return bool
     */
    public function getFile($file_id)
    {
        return $this->getURL(['file_id' => $file_id, 'chat_id' => $this->chat_id], "getFile");
    }

    /**
     * @param $file
     * @param string $text
     * @return bool
     */
    public function sendFileCaptionMarkDown($file, $text = "", $type = 'document', $sender = "sendDocument")
    {
        return $this->cURL([$type => $file, 'chat_id' => $this->chat_id, 'caption' => $text, 'parse_mode' => 'markdown'], $sender);
    }

    /**
     * @param $parameters
     * @param $sender
     * @return bool
     */
    private function cURL($parameters, $sender = "sendMessage")
    {
        foreach ($parameters as $key => &$val) {
            if (!is_numeric($val) && !is_string($val)) {
                $val = json_encode($val);
            }
        }
        $url = self::TELEGRAM_API_URL . $this->token . "/" . $sender . "?" . http_build_query($parameters);
        $handle = curl_init($url);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($handle, CURLOPT_TIMEOUT, 60);
        $result = curl_exec($handle);
        curl_close($handle);
        return json_decode($result, true);
    }

    /**
     * @param $parameters
     * @param $sender
     * @return bool
     */
    private function cUrlOrder($parameters, $sender = "sendMediaGroup")
    {
        foreach ($parameters as $key => &$val) {
            if (!is_numeric($val) && !is_string($val)) {
                $val = json_encode($val);
            }
        }
        $url = self::TELEGRAM_API_URL . self::MUROBAHA_BOT_TOKEN . "/" . $sender . "?" . http_build_query($parameters);
        $handle = curl_init($url);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($handle, CURLOPT_TIMEOUT, 60);
        curl_exec($handle);
        curl_close($handle);
        return true;
    }

    /**
     * @param $parameters
     * @param $sender
     * @return bool
     */
    private function getURL($parameters, $sender = "sendMessage")
    {
        $url = self::TELEGRAM_API_URL . $this->token . "/" . $sender . "?" . http_build_query($parameters);

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        return json_decode($response, true);
    }
}