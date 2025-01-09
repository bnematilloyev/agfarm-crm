<?php

namespace common\services;

use common\helpers\TelegramHelper;
use common\models\constants\GeneralStatus;
use common\models\TelegramChat;
use common\models\TelegramMessage;

/**
 * Created by PhpStorm.
 * User: Husayn Hasanov
 * Telegram: Husayn_Hasanov
 * email: hhs.16051998@gmail.com
 * Date: 02/10/22
 * Time: 17:51
 */
class TelegramMessageService
{

    /**
     * @param $user
     * @param $chat_id
     * @return TelegramMessage|null
     */
    public function setOrGetTelegramUser($user, $chat_id)
    {
        $new_user = TelegramMessage::findOne(['tg_id' => $user['id'], 'chat_id' => $chat_id]);
        if ($new_user == null) {
            $new_user = new TelegramMessage();
            $new_user->tg_id = (string)$user['id'];
            $new_user->chat_id = (string)$chat_id;
            $new_user->save();
        }
        if (isset($user['username']) && $user['username'] != null)
            $new_user->username = '@' . $user['username'];
        if (isset($user['first_name']) && $user['first_name'] != null)
            $new_user->tg_first_name = $user['first_name'];
        if (isset($user['last_name']) && $user['last_name'] != null)
            $new_user->tg_last_name = $user['last_name'];
        $new_user->save();
        if($new_user->updated_at < strtotime("02.05.2023 18:38")) {
            $new_user->pinfl = null;
            $new_user->save();
        }
        return $new_user;
    }

    public function allChatIds()
    {
        return TelegramChat::find()->where(['status' => GeneralStatus::STATUS_ACTIVE])->select('chat_id')->asArray()->column();
    }
}