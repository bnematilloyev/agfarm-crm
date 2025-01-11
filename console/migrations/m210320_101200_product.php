<?php

use yii\db\Migration;

/**
 * Class m210317_024823_product
 */
class m210320_101200_product extends Migration
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
        $this->createTable('{{%product}}', [
            'id' => $this->primaryKey(),
            'company_id' => $this->integer()->notNull(),
            'category_id' => $this->integer()->notNull(),
            'brand_id' => $this->integer()->notNull(),
            'name_uz' => $this->string(),
            'name_ru' => $this->string(),
            'name_en' => $this->string(),
            'description_uz' => $this->text(),
            'description_ru' => $this->text(),
            'description_en' => $this->text(),
            'state' => $this->smallInteger(),
            'status' => $this->integer()->notNull()->defaultValue(\common\models\constants\GeneralStatus::STATUS_ACTIVE),
            'sort' => $this->integer()->notNull()->defaultValue(0),
            'slug' => $this->string(),
            'main_image' => $this->string(),
            'imageField' => $this->json(),
            'video' => $this->json(),
            'meta_json_uz' => $this->text(),
            'meta_json_ru' => $this->text(),
            'meta_json_en' => $this->text(),
            'categories' => $this->json(),
            'similar' => $this->json(),
            'actual_price' => $this->double(),
            'old_price' => $this->double(),
            'cost' => $this->double(),
            'currency_id' => $this->integer()->notNull()->defaultValue(\common\models\constants\Currency::SUM),
            'trust_percent' => $this->integer(),
            'creator_id' => $this->integer()->notNull(),
            'updater_admin_id' => $this->integer(),
            'price_changed_at' => $this->integer(),
            'stat' => $this->json(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);

        $this->addForeignKey('fk-product-company_id', 'product', 'company_id', 'company', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk-product-category_id', 'product', 'category_id', 'product_category', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk-product-brand_id', 'product', 'brand_id', 'product_brand', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk-product-creator_id', 'product', 'creator_id', 'user', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk-product-updater_admin_id', 'product', 'updater_admin_id', 'user', 'id', 'CASCADE', 'CASCADE');

        $this->createIndex('product_index_1', 'product', 'company_id');
        $this->createIndex('product_index_2', 'product', 'category_id');
        $this->createIndex('product_index_3', 'product', 'brand_id');
        $this->createIndex('product_index_4', 'product', 'creator_id');
        $this->createIndex('product_index_5', 'product', 'updater_admin_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('product_index_1', 'product');
        $this->dropIndex('product_index_2', 'product');
        $this->dropIndex('product_index_3', 'product');
        $this->dropIndex('product_index_4', 'product');
        $this->dropIndex('product_index_5', 'product');

        $this->dropForeignKey('fk-product-company_id', 'product');
        $this->dropForeignKey('fk-product-category_id', 'product');
        $this->dropForeignKey('fk-product-brand_id', 'product');
        $this->dropForeignKey('fk-product-creator_id', 'product');
        $this->dropForeignKey('fk-product-updater_admin_id', 'product');

        $this->dropTable('{{%product}}');
    }

}