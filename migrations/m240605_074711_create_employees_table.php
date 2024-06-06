<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%employees}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%users}}`
 * - `{{%strg_posts}}`
 */
class m240605_074711_create_employees_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%employees}}', [
            'id' => $this->primaryKey(),
            'users_id' => $this->integer()->notNull(),
            'strg_posts_id' => $this->integer()->notNull(),
        ]);

        // creates index for column `users_id`
        $this->createIndex(
            '{{%idx-employees-users_id}}',
            '{{%employees}}',
            'users_id'
        );

        // add foreign key for table `{{%users}}`
        $this->addForeignKey(
            '{{%fk-employees-users_id}}',
            '{{%employees}}',
            'users_id',
            '{{%users}}',
            'id',
            'CASCADE'
        );

        // creates index for column `strg_posts_id`
        $this->createIndex(
            '{{%idx-employees-strg_posts_id}}',
            '{{%employees}}',
            'strg_posts_id'
        );

        // add foreign key for table `{{%strg_posts}}`
        $this->addForeignKey(
            '{{%fk-employees-strg_posts_id}}',
            '{{%employees}}',
            'strg_posts_id',
            '{{%strg_posts}}',
            'id',
            'CASCADE'
        );

        Yii::$app->db->createCommand()->batchInsert('employees', ['users_id', 'strg_posts_id'], [
            [1, 1]
        ])->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%users}}`
        $this->dropForeignKey(
            '{{%fk-employees-users_id}}',
            '{{%employees}}'
        );

        // drops index for column `users_id`
        $this->dropIndex(
            '{{%idx-employees-users_id}}',
            '{{%employees}}'
        );

        // drops foreign key for table `{{%strg_posts}}`
        $this->dropForeignKey(
            '{{%fk-employees-strg_posts_id}}',
            '{{%employees}}'
        );

        // drops index for column `strg_posts_id`
        $this->dropIndex(
            '{{%idx-employees-strg_posts_id}}',
            '{{%employees}}'
        );

        $this->dropTable('{{%employees}}');
    }
}
