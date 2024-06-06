<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%users}}`.
 */
class m240605_074656_create_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%users}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string(255)->unique()->notNull(),
            'password' => $this->text()->notNull(),
            'firstname' => $this->string(255)->notNull(),
            'secondname' => $this->string(255)->notNull(),
            'thirdname' => $this->string(255)->null(),
        ]);

        Yii::$app->db->createCommand()->batchInsert('users', ['username', 'password', 'firstname', 'secondname', 'thirdname'], [
            ['admin', '424242', 'Admin', 'Admin', 'Admin']
        ])->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%users}}');
    }
}
