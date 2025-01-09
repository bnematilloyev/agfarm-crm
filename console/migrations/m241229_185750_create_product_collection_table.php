<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%product_collection}}`.
 */
class m241229_185750_create_product_collection_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%product_collection}}', [
            'id' => $this->primaryKey(),
            'name_uz' => $this->string(),
            'name_ru' => $this->string(),
            'name_en' => $this->string(),
            'product_id' => $this->integer(),
            'product_list' => $this->json(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);
        $this->addForeignKey('fk-product_collection-product_id', '{{%product_collection}}', 'product_id', '{{%product}}', 'id', 'CASCADE', 'CASCADE');
        $this->createIndex('idx-product_collection-product_id', '{{%product_collection}}', 'product_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-product_collection-product_id', '{{%product_collection}}');
        $this->dropIndex('idx-product_collection-product_id', '{{%product_collection}}');
        $this->dropTable('{{%product_collection}}');
    }
}
