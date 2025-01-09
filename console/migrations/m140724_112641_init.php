<?php

use common\models\Company;
use common\models\constants\GeneralStatus;
use common\models\constants\UserRole;
use common\models\Market;
use yii\db\Migration;

/**
 * Class m140724_112641_init
 */
class m140724_112641_init extends Migration
{
    /**
     * @throws \yii\base\Exception
     */
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%company}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'address' => $this->string()->null(),
            'status' => $this->smallInteger()->notNull()->defaultValue(GeneralStatus::STATUS_INACTIVE),
            'key' => $this->string(512)->notNull()->unique(),
            'phone' => $this->string()->null(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);

        $this->insert('{{%company}}', [
            'name' => 'ABDULLO GRAND FARM',
            'status' => GeneralStatus::STATUS_ACTIVE,
            'key' => Yii::$app->security->generateRandomString(128),
            'phone' => '+998931740300',
            'address' => 'Namangan viloyati, Namangan sh., Yangi Namangan tumani Furqat MFY, I.Karimov ko`chasi, 5-uy',
            'created_at' => time(),
            'updated_at' => time(),
        ]);

        $this->createTable('{{%market}}', [
            'id' => $this->primaryKey(),
            'company_id' => $this->integer()->notNull(),
            'name' => $this->string()->notNull(),
            'address' => $this->string()->null(),
            'status' => $this->smallInteger()->notNull()->defaultValue(GeneralStatus::STATUS_ACTIVE),
            'phone' => $this->string()->null(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);

        $this->createIndex('market_index_1', '{{%market}}', 'company_id');
        $this->addForeignKey('market_company_id_fk', '{{%market}}', 'company_id', '{{%company}}', 'id', 'CASCADE', 'CASCADE');

        $this->insert('{{%market}}', [
            'name' => 'Asosiy Do`kon',
            'company_id' => Company::ABDULLO_GRAND_FARM,
            'status' => GeneralStatus::STATUS_ACTIVE,
            'phone' => '+998933741511',
            'address' => 'Yangi Namangan tumani Furqat MFY, I.Karimov ko`chasi, 5-uy',
            'created_at' => time(),
            'updated_at' => time(),
        ]);

        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'company_id' => $this->integer()->notNull(),
            'market_id' => $this->integer()->notNull(),
            'full_name' => $this->string()->notNull(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'phone' => $this->string()->unique(),
            'status' => $this->smallInteger()->notNull()->defaultValue(GeneralStatus::STATUS_INACTIVE),
            'role' => $this->integer()->defaultValue(UserRole::ROLE_GUEST),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);
        $this->createIndex('user_index_1', '{{%user}}', 'company_id');
        $this->createIndex('user_index_2', '{{%user}}', 'market_id');

        $this->insert('{{%user}}', [
            'full_name' => 'Botir Nematilloyev',
            'company_id' => Company::ABDULLO_GRAND_FARM,
            'market_id' => Market::MAIN,
            'auth_key' => Yii::$app->security->generateRandomString(),
            'password_hash' => Yii::$app->security->generatePasswordHash('password'),
            'password_reset_token' => Yii::$app->security->generateRandomString(),
            'phone' => '+998933741511',
            'status' => GeneralStatus::STATUS_ACTIVE,
            'role' => UserRole::ROLE_CREATOR,
            'created_at' => time(),
            'updated_at' => time(),
        ]);
    }

    public function down()
    {
        $this->dropIndex('market_index_1', '{{%market}}');
        $this->dropIndex('user_index_1', '{{%user}}');
        $this->dropIndex('user_index_2', '{{%user}}');
        $this->dropTable('{{%user}}');
        $this->dropTable('{{%market}}');
        $this->dropTable('{{%company}}');
    }
}
