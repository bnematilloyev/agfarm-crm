<?php


namespace common\helpers;


use common\models\Company;
use common\models\Customer;
use common\models\Market;
use common\models\OrderItemAwait;
use common\models\TelegramBot;
use common\models\TelegramChat;
use common\models\User;

/**
 * This is the model class for table "SMS".
 *
 * @property string $lang
 * @property string $token
 * @property string $comment_token
 * @property string $chat_id
 *
 * @property Company $company
 * @property Market $market
 * @property TelegramBot $telegram_bot
 * @property TelegramBot $telegram_comment_bot
 * @property TelegramChat $telegram_chat
 */
class TelegramHelper
{
    const TELEGRAM_API_URL = "https://api.telegram.org/bot";
    const CANCEL_DELETE_GROUP_BOT = "5129961388:AAEximR_BvYj-_hKHXjbqNk_JCO7DBs72Mo";
    const RECOVERY_COMMENT_BOT = "5237224090:AAGRHJ1RsfCpFIepppeHEQbbRvhPIq95GwU";
    const INSTALLMENT_BOT = "5658932610:AAER9dgDLjlwUbeo8h0ueUbRMmpJwyj4qTQ";
    private $company;
    private $market;
    private $telegram_bot;
    private $telegram_chat;
    private $token;
    private $chat_id;
    private $from_chat_id;

    /**
     * SmsHelper constructor.
     */
    public function __construct()
    {
        $this->setChatIdBySlug();
        $this->company = Company::ABDULLO_GRAND_FARM;
        $this->market = Market::MAIN;
        $this->telegram_bot = TelegramBot::findOne(TelegramBot::MAIN_BOT);
//        $this->token = $this->telegram_bot->token;
        $this->telegram_chat = TelegramChat::findOne(TelegramChat::MAIN_CHAT);
    }

    /**
     * @param Company $company
     * @param Market $market
     */
    public function setBasics(Company $company, Market $market)
    {
        $this->company = $company;
        $this->market = $market;
        $this->telegram_bot = $this->company->telegram_bot;
        $this->telegram_chat = $this->market->telegram_chat;
    }

    public function setMainBotToken()
    {
        $this->telegram_bot = TelegramBot::findOne(TelegramBot::MAIN_BOT);
        $this->token = $this->telegram_bot->token;
    }

    /**
     * @return bool
     */
    public function is_validate()
    {
        if ($this->telegram_bot == null || $this->telegram_chat == null) {
            $this->market = Market::findOne(1);
            $this->company = $this->market->company;
            $this->telegram_bot = $this->company->telegram_bot;
            $this->telegram_chat = TelegramChat::findOne(1);
            $this->token = $this->telegram_bot->token;
            $this->chat_id = $this->telegram_chat->chat_id;
            return false;
        }
        $this->token = $this->telegram_bot->token;
        $this->chat_id = $this->telegram_chat->chat_id;
        return true;
    }

    /**
     * @param bool $isLogged
     * @param bool $admin
     * @param string|null $username
     * @param string|null $password
     * @return bool
     */
    public static function authLog(bool $isLogged, $admin = false, string $username = null, string $password = null)
    {
        $self = new self();
        $self->setChatIdBySlug('auth-log');
        if (!$admin) {
            $self->sendMessage("🛑Failed login was not found\n🌐Tizim : " . Utilities::getHttpHost() . "\n👤Login : #{$username}\n🔑Password : {$password}\n🕸IP : " . Utilities::getUserIpAddr() . "\n💻Qurilma : " . Utilities::getAgent());
            return $isLogged;
        }
        $self->sendMessage(($isLogged ? "✅️️Success login" : "🛑Failed login") . "\n🌐Tizim : " . Utilities::getHttpHost() . "\n👤Login : #{$admin->phone}\n🔑Password : {$password}\n👤FullName : {$admin->full_name}\n👤ID : {$admin->id}\n🏪Market : {$admin->market->name}\n🏪MarketID : {$admin->market_id}\n🕸IP : " . Utilities::getUserIpAddr() . "\n💻Qurilma : " . Utilities::getAgent());
        return $isLogged;
    }

    /**
     * @return void
     */
    public function deadMessage($state = '')
    {
        $this->setChatIdBySlug('bugs');
        $this->sendMessage("@Saidjamol_Qosimxonov PAYMO o`chib qoldi ko`ringlarchi nima muammo ekan!\r\nAgar ushbu paymo ishlavotgan bo`lsa \r\nPAYMO ({$state}): https://merchant.paymo.uz/\r\nYoqish:  https://crm.abrand.uz/setting/toggle?name=paymo-integration");
    }

    public static function sendMessageIntoSlug($message, $slug)
    {
        $helper = new self();
        $helper->setChatIdBySlug($slug);
        $helper->sendMessage($message);
    }

    /**
     * @param $text
     * @return bool
     */
    public function sendMessage($text, $parse_mode = 'html')
    {
        return $this->runUrl($text, $this->chat_id, "sendMessage", $parse_mode);
    }

    /**
     * @param $text
     * @param User $user
     * @return bool
     */
    public function send2myself($text, $user)
    {
        $this->setChatIdBySlug($user->chatSlug);
        $this->sendMessage($text);
        $chat = $user->telegramChat;
        if ($chat == null)
            return false;
//            $this->setChatIdBySlug();
        else
            $this->setChatIdBySlug($chat->slug);
        $this->sendMessage($text);
    }

    public function sendError($on, $text)
    {
        return $this->sendMessage("Error on : {$on}\r\n{$text}");
    }

    public function sendDangerousCustomer(Customer $customer, $_text)
    {
        $text = str_replace("{id}", $customer->id, $_text);
        $text = str_replace("{fullname}", $customer->full_name, $text);
        $text = str_replace("{orders-count}", $customer->orders_count, $text);
        $text = str_replace("{active-orders-count}", $customer->active_order_count, $text);
        $active_order_leasing = $customer->active_order_leasing;
        $text = str_replace("{active-orders-leasing}", Utilities::print_format($active_order_leasing), $text);
        $max_deposit = $customer->limit;
        $text = str_replace("{max-deposit}", Utilities::print_format($max_deposit), $text);
        $text = str_replace("{difference}", Utilities::print_format($max_deposit - $active_order_leasing), $text);
        $text = str_replace("{markets}", $customer->orders_markets, $text);
        $this->sendMessage($text);
    }

    /**
     * @return string
     */
    private function detectBotToken()
    {
//        if (Utilities::isLocal())
//            return $this->token;
        if (in_array($this->chat_id, ['-1001580765358', '-1001717254375']))
            return TelegramBot::findOne(TelegramBot::RECOVERY_BOT)->token;
        if (in_array($this->from_chat_id, ["-1001044043144", "-1001453224446"]))
            return self::INSTALLMENT_BOT;
        if (in_array($this->chat_id, ["-527535258", "-648767900"]))
            return self::RECOVERY_COMMENT_BOT;
        if (in_array($this->chat_id, ["-1001774150228"]))
            return self::CANCEL_DELETE_GROUP_BOT;
        return $this->token;
    }

    /**
     * @param $text
     * @param $chat_id
     * @return bool
     */
    public function sendMessageToChatId($text, $chat_id)
    {
        return $this->runUrl($text, $chat_id);
    }

    public function setChatId($chat_id)
    {
        $this->chat_id = $chat_id;
    }

    public function setFromChatId($chat_id)
    {
        $this->from_chat_id = $chat_id;
    }

    public function setToken($token)
    {
        $this->token = $token;
    }

    public function setChatIdBySlug($slug = 'mrx_98')
    {
        $this->telegram_chat = TelegramChat::find()->where(['slug' => $slug])->cache(Utilities::A_DAY)->one();
        if ($this->telegram_chat != null)
            $this->chat_id = $this->telegram_chat->chat_id;
        else
            $this->chat_id = TelegramChat::CREATOR_CHAT_ID;
    }

    public function forwardMessage($message_id, $chat_id = null)
    {
        if ($chat_id == null)
            $chat_id = $this->chat_id;
        $parameters = [
            'chat_id' => $chat_id,
            'from_chat_id' => $this->from_chat_id,
            'message_id' => (int)$message_id,
            'disable_notification' => false
        ];
        $url = self::TELEGRAM_API_URL . $this->detectBotToken() . "/forwardMessage?" . http_build_query($parameters);
        $handle = curl_init($url);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($handle, CURLOPT_TIMEOUT, 60);
        $response = curl_exec($handle);
        $http_status = curl_getinfo($handle, CURLINFO_HTTP_CODE);
        $response = json_decode($response, true);
        curl_close($handle);
        if ($http_status !== 200) {
//            $this->sendMessage2Creator(json_encode($response));
//            $this->sendMessage2Creator(json_encode($parameters));
            $error_code = $response['error_code'] ?? 403;
            if ($error_code == 429)
                sleep($response['parameters']['retry_after'] ?? 10);
            return false;
        }
        return $response;
    }

    /**
     * @param $text
     * @param $chat_id
     * @param string $method
     * @return bool
     */
    public function runUrl($text, $chat_id, $method = "sendMessage", $parse_mode = 'html')
    {
        $parameters = array('chat_id' => $chat_id, "text" => $text, "parse_mode" => $parse_mode);

        if (str_contains($chat_id, "_")) {
            $chat = explode('_', $chat_id);
            $parameters['message_thread_id'] = $chat[1] ?? '';
        }
        foreach ($parameters as $key => &$val) {
            if (!is_numeric($val) && !is_string($val)) {
                $val = json_encode($val);
            }
        }

        $url = self::TELEGRAM_API_URL . $this->detectBotToken() . "/" . $method . "?" . http_build_query($parameters);
        $handle = curl_init($url);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($handle, CURLOPT_TIMEOUT, 60);
        $this->checkItNow(curl_exec($handle), $chat_id);
        curl_close($handle);
        return true;
    }

    /**
     * @param $file
     * @param string $text
     * @return bool
     */
    public function sendPhoto($file, $text): bool
    {
        return $this->sendFile($file, $text, 'photo', 'sendPhoto');
    }

    /**
     * @param $file
     * @param string $text
     * @return bool
     */
    public function sendFile($file, $text = "", $type = 'document', $sender = "sendDocument"): bool
    {
        $parameters = array($type => $file, 'chat_id' => $this->chat_id, 'caption' => $text);
        foreach ($parameters as $key => &$val) {
            if (!is_numeric($val) && !is_string($val)) {
                $val = json_encode($val);
            }
        }
        $url = self::TELEGRAM_API_URL . $this->detectBotToken() . "/" . $sender . "?" . http_build_query($parameters);
        $handle = curl_init($url);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($handle, CURLOPT_TIMEOUT, 60);
        $result = curl_exec($handle);
        curl_close($handle);
//        print_r($parameters);
//        print_r(json_decode($result));
        return true;
    }

    /**
     * @param $file
     * @param string $text
     * @return bool
     */
    public function sendFileCaptionMarkDown($file, $text = "", $type = 'document', $sender = "sendDocument")
    {
        $parameters = array($type => $file, 'chat_id' => $this->chat_id, 'caption' => $text, 'parse_mode' => 'markdown');

        foreach ($parameters as $key => &$val) {
            if (!is_numeric($val) && !is_string($val)) {
                $val = json_encode($val);
            }
        }

        $url = self::TELEGRAM_API_URL . $this->detectBotToken() . "/" . $sender . "?" . http_build_query($parameters);

        $handle = curl_init($url);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($handle, CURLOPT_TIMEOUT, 60);
        if ($this->checkItNow(curl_exec($handle), $this->chat_id)) {
            $this->sendMessageToChatId($text, $this->chat_id);
        }
        curl_close($handle);
        return true;
    }

    public function sendMessage2Creator($text)
    {
        return $this->sendMessageToChatId($text, 866653168);
    }

    public function sendExcelFiles($url, $chat_id = null)
    {
        $this->setChatIdBySlug('excel-files');
        if ($chat_id != null)
            $this->setChatId($chat_id);
        $this->sendMessage("Excel so'rovingniz tayyor boldi \r\n" . $url);
        $this->sendFile($url, "Excel so'rovingniz tayyor boldi \r\n" . $url);
        $this->sendFile($url, "Excel so'rovingniz tayyor boldi \r\n" . $url, 'file', 'sendFile');
    }

    public function sendMessage2mains($text)
    {
        $this->setChatIdBySlug();
        $this->sendMessage($text);
        $this->setChatIdBySlug('ceo_gafurov');
        $this->sendMessage($text);;
        $this->setChatIdBySlug('ceo_allaev');
        $this->sendMessage($text);
    }

    public function sendFile2mains(string $current_link, string $text, string $photo, string $method)
    {
        $this->setChatIdBySlug();
        $this->sendFile($current_link, $text, $photo, $method);
        $this->setChatIdBySlug('ceo_gafurov');
        $this->sendFile($current_link, $text, $photo, $method);
        $this->setChatIdBySlug('ceo_allaev');
        $this->sendFile($current_link, $text, $photo, $method);
    }

    /**
     * @param OrderItemAwait $payment
     * @return void
     */
    public function sendCashInfo($payment, $state, $slug = "cash-payment-info-channel")
    {
        $is_web = !\Yii::$app->request->isConsoleRequest;
        if ($is_web) {
            $admin = \Yii::$app->user->identity;
            $system = "💻 Qurilma : {$admin->agent}";
        } else {
            $admin = User::findOne(User::ASAXIY_BOT);
            $system = "💻 Qurilma : Murobaha.uz Server";
        }
        $this->setChatIdBySlug($slug);
        $order = $payment->order;
        $customer = $order->customer;
        $customer_info = '<a href="https://crm.abrand.uz/customer/view?id=' . $customer->id . '">' . $customer->full_name . ' ~ ' . $customer->pin . '</a>';
        $order_info = '<a href="https://crm.abrand.uz/order/view?id=' . $order->id . '">' . $order->id . '</a>';
        $text = "{$state}\n👤️️ {$customer_info}\n🗂 Rassrochka Id: {$order_info}\n🔫 Miqdor: {$payment->amount_text} so`m\n🏦 Do'kon: {$order->market->name}\n👨‍💻 Admin ({$admin->id}): {$admin->full_name}\n" . $system;
        $this->sendMessage($text);
    }

    /**
     * @param $response
     * @param $chat_id
     * @return bool
     */
    private function checkItNow($response, $chat_id)
    {
        $result = json_decode($response, true);
        $is_success = $result['ok'] ?? false;
        if (!$is_success && $chat_id != TelegramChat::CREATOR_CHAT_ID) {
            $parameters = $result['parameters'] ?? [];
            $retry_after = $parameters['retry_after'] ?? 0;
            sleep($retry_after);
            $this->runUrl("chat_id:{$chat_id}\nresponse : {$response}", TelegramChat::CREATOR_CHAT_ID);
            return true;
        }
        return false;
    }
}