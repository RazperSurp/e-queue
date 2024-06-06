<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%strg_posts}}`.
 */
class m240605_074706_create_strg_posts_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%strg_posts}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull()->unique(),
        ]);

        Yii::$app->db->createCommand()->batchInsert('strg_posts', ['name'], [
            ['Директор'],
            ['Специалист'],
            ['Оператор'],
            ['Старший дворник'],
        ])->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%strg_posts}}');
    }
}
