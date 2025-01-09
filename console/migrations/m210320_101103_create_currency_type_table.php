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
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%currency_type}}');
    }
}
