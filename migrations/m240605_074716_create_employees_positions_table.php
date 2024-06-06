<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%employees_positions}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%employees}}`
 */
class m240605_074716_create_employees_positions_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%employees_positions}}', [
            'id' => $this->primaryKey(),
            'time_start' => $this->integer()->notNull(),
            'time_end' => $this->integer()->notNull(),
            'position' => $this->integer()->notNull(),
            'employees_id' => $this->integer()->notNull(),
        ]);

        // creates index for column `employees_id`
        $this->createIndex(
            '{{%idx-employees_positions-employees_id}}',
            '{{%employees_positions}}',
            'employees_id'
        );

        // add foreign key for table `{{%employees}}`
        $this->addForeignKey(
            '{{%fk-employees_positions-employees_id}}',
            '{{%employees_positions}}',
            'employees_id',
            '{{%employees}}',
            'id',
            'CASCADE'
        );

        Yii::$app->db->createCommand()->batchInsert('employees_positions', ['time_start', 'time_end', 'position', 'employees_id'], [
            [0, time() + 99999, 1, 1]
        ])->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%employees}}`
        $this->dropForeignKey(
            '{{%fk-employees_positions-employees_id}}',
            '{{%employees_positions}}'
        );

        // drops index for column `employees_id`
        $this->dropIndex(
            '{{%idx-employees_positions-employees_id}}',
            '{{%employees_positions}}'
        );

        $this->dropTable('{{%employees_positions}}');
    }
}
