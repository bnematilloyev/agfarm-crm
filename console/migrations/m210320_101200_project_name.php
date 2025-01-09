<?php

use common\models\constants\ProjectType;
use yii\db\Migration;

/**
 * Class m210317_024823_project_name
 */
class m210320_101200_project_name extends Migration
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
        $this->createTable('{{%project_name}}', [
            'id' => $this->primaryKey(),
            'login_name' => $this->string()->notNull(),
            'index_name' => $this->string()->notNull(),
            'title_name' => $this->string()->notNull(),
            'navbar_name' => $this->string()->notNull(),
            'short_name' => $this->string()->notNull(),
            'company_id' => $this->integer()->notNull()->defaultValue(1),
            'type' => $this->integer()->notNull()->defaultValue(ProjectType::CRM),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);

        $this->insert('{{%project_name}}', [
            'id' => 1,
            'login_name' => '<b>CRM Abdullo GRAND FARM</b>',
            'index_name' => '<b>CRM Abdullo GRAND FARM</b>',
            'title_name' => 'GRAND FARM',
            'navbar_name' => '<b>CRM</b> ',
            'short_name' => '<b>GRAND FARM</b>',
            'created_at' => time(),
            'updated_at' => time(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%project_name}}');
    }

}