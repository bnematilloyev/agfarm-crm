<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%currency_type}}`.
 */
class m210320_101103_create_currency_type_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%currency_type}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'value' => $this->double(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

        $this->insert('{{%currency_type}}', [
            'name' => 'UZS',
            'value' => 1,
            'created_at' => time(),
            'updated_at' => time(),
        ]);

        $this->insert('{{%currency_type}}', [
            'name' => 'USD',
            'value' => 12960,
            'created_at' => time(),
            'updated_at' => time(),
        ]);

        $this->insert('{{%currency_type}}', [
            'name' => 'RUB',
            'value' => 116.68,
            'created_at' => time(),
            'updated_at' => time(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%currency_type}}');
    }
}
