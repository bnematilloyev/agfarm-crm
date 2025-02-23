<?php

use yii\db\Migration;

class m250109_110858_add_column_status_to_product_category_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%product_category}}', 'status', $this->integer()->defaultValue(\common\models\constants\GeneralStatus::STATUS_ACTIVE));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%product_category}}', 'status');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250109_110858_add_column_status_to_product_category_table cannot be reverted.\n";

        return false;
    }
    */
}
