<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%task_list}}`.
 */
class m191121_115448_create_task_list_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%task_list}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'data' => $this->text()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%task_list}}');
    }
}
