<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%product_option_name}}`.
 */
class m250114_103853_create_product_option_name_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%product_option_name}}', [
            'id' => $this->primaryKey(),
            'name_uz' => $this->string(),
            'name_ru' => $this->string(),
            'name_en' => $this->string(),
            'status' => $this->integer()->defaultValue(\common\models\constants\GeneralStatus::STATUS_ACTIVE),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%product_option_name}}');
    }
}
