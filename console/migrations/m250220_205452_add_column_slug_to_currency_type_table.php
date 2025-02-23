<?php

use yii\db\Migration;

class m250220_205452_add_column_slug_to_currency_type_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%currency_type}}', 'slug', $this->string());
    }


    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%currency_type}}', 'slug');
    }
}
