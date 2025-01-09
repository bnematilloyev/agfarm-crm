<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "telegram_bot".
 *
 * @property int $id
 * @property int $company_id
 * @property string $token
 * @property int $status
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property TelegramChat[] $chats
 */
class TelegramBot extends BaseTimestampedModel
{
    const MAIN_BOT = 1;
    const RECOVERY_BOT = 4;
    const INFO_BOT = "7737275875:AAE7s76pS7IdJLlzFBlWCOdnMxJjgCZbH5g";

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'telegram_bot';
    }

    /**
     * {@inheritdoc}
     */
    public function getTableName()
    {
        return self::tableName();
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['company_id', 'token'], 'required'],
            [['company_id', 'status', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['company_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['token'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'company_id' => Yii::t('app', 'Company ID'),
            'token' => Yii::t('app', 'Token'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return array
     */
    public function getChats()
    {
        $chats = [];
        foreach ($this->company->markets as $market)
            $chats[] = $market->telegram_chat;
        return $chats != null && is_array($chats) && count($chats) ? $chats : [
            new TelegramChat()
        ];
    }

    public function getFirst_chat()
    {
        return $this->chats[0];
    }
}
