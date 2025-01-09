<?php

use yii\db\Migration;

/**
 * Class m210521_054702_telegram_notifier
 */
class m210521_054702_telegram_notifier extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%telegram_bot}}', [
            'id' => $this->primaryKey(),
            'company_id' => $this->integer()->notNull(),
            'token' => $this->string()->notNull(),
            'status' => $this->integer()->notNull()->defaultValue(\common\models\constants\GeneralStatus::STATUS_ACTIVE),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);
        $this->createIndex('telegram_bot_index_1', '{{%telegram_bot}}', 'company_id');

        $this->createTable('{{%telegram_chat}}', [
            'id' => $this->primaryKey(),
            'company_id' => $this->integer()->notNull(),
            'market_id' => $this->integer()->notNull(),
            'chat_id' => $this->string()->notNull(),
            'slug' => $this->string(),
            'user_id' => $this->integer(),
            'status' => $this->integer()->notNull()->defaultValue(\common\models\constants\GeneralStatus::STATUS_ACTIVE),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);
        $this->createIndex('telegram_chat_index_1', '{{%telegram_chat}}', 'company_id');
        $this->createIndex('telegram_chat_index_2', '{{%telegram_chat}}', 'market_id');
        $this->createIndex('telegram_chat_index_3', '{{%telegram_chat}}', 'user_id');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('telegram_bot_index_1', '{{%telegram_bot}}');
        $this->dropIndex('telegram_chat_index_1', '{{%telegram_chat}}');
        $this->dropIndex('telegram_chat_index_2', '{{%telegram_chat}}');

        $this->dropTable("telegram_chat");
        $this->dropTable("telegram_bot");
    }
}
