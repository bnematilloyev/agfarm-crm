<?php

use yii\db\Migration;

/**
 * Class m210317_024823_brand
 */
class m210320_101100_product_brand extends Migration
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
        $this->createTable('{{%product_brand}}', [
            'id' => $this->primaryKey(),
            'name_uz' => $this->string(),
            'name_ru' => $this->string(),
            'name_en' => $this->string(),
            'slug' => $this->string(),
            'image' => $this->string(),
            'home_page' => $this->boolean(),
            'meta_json_uz' => $this->json(),
            'meta_json_ru' => $this->json(),
            'meta_json_en' => $this->json(),
            'status' => $this->integer()->notNull()->defaultValue(\common\models\constants\GeneralStatus::STATUS_ACTIVE),
            'official_link' => $this->string(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%product_brand}}');
    }

}