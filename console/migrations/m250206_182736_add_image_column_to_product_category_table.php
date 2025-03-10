<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%product_category}}`.
 */
class m250206_182736_add_image_column_to_product_category_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('product_category', 'image', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('product_category', 'image');
    }
}
