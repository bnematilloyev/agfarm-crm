<?php

namespace common\models;

use common\helpers\TelegramHelper;
use Yii;

/**
 * This is the model class for table "telegram_chat".
 *
 * @property int $id
 * @property int $company_id
 * @property int $market_id
 * @property int $user_id
 * @property string $chat_id
 * @property string $slug
 * @property int $status
 * * @property Company $company
 * @property int|null $created_at
 * @property int|null $updated_at
 */
class TelegramChat extends BaseTimestampedModel
{

    const CREATOR_CHAT_ID = 866653168;
    const MAIN_CHAT = 1;
    public $custom_text;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'telegram_chat';
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
            [['company_id', 'market_id', 'chat_id'], 'required'],
            [['company_id', 'market_id', 'status', 'created_at', 'updated_at', 'user_id', 'slug'], 'default', 'value' => null],
            [['company_id', 'market_id', 'status', 'created_at', 'updated_at', 'user_id'], 'integer'],
            [['chat_id', 'slug'], 'string', 'max' => 255],
            [['custom_text'], 'safe']
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
            'market_id' => Yii::t('app', 'Market ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'chat_id' => Yii::t('app', 'Chat ID'),
            'custom_text' => Yii::t('app', 'Xabar'),
            'status' => Yii::t('app', 'Status'),
            'slug' => Yii::t('app', 'Kalit so`z'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompany()
    {
        return $this->hasOne(Company::className(), ['id' => 'company_id']);
    }

    public function sendMessage()
    {
        $service = new TelegramHelper(!Yii::$app->request->isConsoleRequest);
        $service->setChatIdBySlug($this->slug);
        $service->sendMessage($this->custom_text);
    }
}
