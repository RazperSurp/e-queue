<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%clients}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%employees_positions}}`
 */
class m240605_074723_create_clients_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%clients}}', [
            'id' => $this->primaryKey(),
            'employees_positions_id' => $this->integer()->null(),
            'firstname' => $this->string(255)->notNull(),
            'secondname' => $this->string(255)->notNull(),
            'thirdname' => $this->string(255)->null(),
            'phone' => $this->string(255)->notNull(),
            'time' => $this->integer()->notNull(),
            'closed' => $this->boolean()->null()->defaultValue(false),
        ]);

        // creates index for column `employees_positions_id`
        $this->createIndex(
            '{{%idx-clients-employees_positions_id}}',
            '{{%clients}}',
            'employees_positions_id'
        );

        // add foreign key for table `{{%employees_positions}}`
        $this->addForeignKey(
            '{{%fk-clients-employees_positions_id}}',
            '{{%clients}}',
            'employees_positions_id',
            '{{%employees_positions}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%employees_positions}}`
        $this->dropForeignKey(
            '{{%fk-clients-employees_positions_id}}',
            '{{%clients}}'
        );

        // drops index for column `employees_positions_id`
        $this->dropIndex(
            '{{%idx-clients-employees_positions_id}}',
            '{{%clients}}'
        );

        $this->dropTable('{{%clients}}');
    }
}
