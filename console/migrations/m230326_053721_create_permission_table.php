<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%permission}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%user}}`
 */
class m230326_053721_create_permission_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%permission}}', [
            'id' => $this->primaryKey(),
            'position' => $this->string(),
            'name' => $this->text(),
            'action_id' => $this->string(),
            'user_id' => $this->integer(),
            'permission' => $this->integer()->defaultValue(0),
        ]);

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-permission-user_id}}',
            '{{%permission}}',
            'user_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-permission-user_id}}',
            '{{%permission}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-permission-user_id}}',
            '{{%permission}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-permission-user_id}}',
            '{{%permission}}'
        );

        $this->dropTable('{{%permission}}');
    }
}
