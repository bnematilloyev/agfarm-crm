<?php

use yii\db\Migration;

class m250206_201937_add_column_wallpaper_to_brand_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%product_brand}}', 'description_uz', $this->text());
        $this->addColumn('{{%product_brand}}', 'description_ru', $this->text());
        $this->addColumn('{{%product_brand}}', 'description_en', $this->text());
        $this->addColumn('{{%product_brand}}', 'wallpaper', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%product_brand}}', 'description_uz');
        $this->dropColumn('{{%product_brand}}', 'description_ru');
        $this->dropColumn('{{%product_brand}}', 'description_en');
        $this->dropColumn('{{%product_brand}}', 'wallpaper');
    }
}
