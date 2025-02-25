<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%product_option}}`.
 */
class m250114_103909_create_product_option_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%product_option}}', [
            'id' => $this->primaryKey(),
            'option_type' => $this->integer()->notNull(),
            'option_name' => $this->integer()->notNull(),
            'value' => $this->string()->notNull(),
            'product_id' => $this->integer()->notNull(),
            'status' => $this->integer()->defaultValue(\common\models\constants\GeneralStatus::STATUS_ACTIVE),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey('fk_product_option_product_id', 'product_option', 'product_id', 'product', 'id', 'CASCADE');
        $this->addForeignKey('fk-product_option_option_type', 'product_option', 'option_type', 'product_option_type', 'id', 'CASCADE');
        $this->addForeignKey('fk-product_option_option_name', 'product_option', 'option_name', 'product_option_name', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_product_option_product_id', 'product_option');
        $this->dropForeignKey('fk-product_option_option_type', 'product_option');
        $this->dropForeignKey('fk-product_option_option_name', 'product_option');
        $this->dropTable('{{%product_option}}');
    }
}
