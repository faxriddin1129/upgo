<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%permission_user}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%permission}}`
 * - `{{%User}}`
 */
class m230329_104247_create_permission_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%permission_user}}', [
            'id' => $this->primaryKey(),
            'permission_id' => $this->integer(),
            'user_id' => $this->integer(),
            'position' => $this->string(),
            'permission' => $this->integer(),
        ]);

        // creates index for column `permission_id`
        $this->createIndex(
            '{{%idx-permission_user-permission_id}}',
            '{{%permission_user}}',
            'permission_id'
        );

        // add foreign key for table `{{%permission}}`
        $this->addForeignKey(
            '{{%fk-permission_user-permission_id}}',
            '{{%permission_user}}',
            'permission_id',
            '{{%permission}}',
            'id',
            'CASCADE'
        );

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-permission_user-user_id}}',
            '{{%permission_user}}',
            'user_id'
        );

        // add foreign key for table `{{%User}}`
        $this->addForeignKey(
            '{{%fk-permission_user-user_id}}',
            '{{%permission_user}}',
            'user_id',
            '{{%User}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%permission}}`
        $this->dropForeignKey(
            '{{%fk-permission_user-permission_id}}',
            '{{%permission_user}}'
        );

        // drops index for column `permission_id`
        $this->dropIndex(
            '{{%idx-permission_user-permission_id}}',
            '{{%permission_user}}'
        );

        // drops foreign key for table `{{%User}}`
        $this->dropForeignKey(
            '{{%fk-permission_user-user_id}}',
            '{{%permission_user}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-permission_user-user_id}}',
            '{{%permission_user}}'
        );

        $this->dropTable('{{%permission_user}}');
    }
}
