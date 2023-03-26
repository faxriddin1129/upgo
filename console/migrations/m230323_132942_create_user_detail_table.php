<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_detail}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%user}}`
 * - `{{%file}}`
 */
class m230323_132942_create_user_detail_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_detail}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'first_name' => $this->string(),
            'last_name' => $this->string(),
            'middle_name' => $this->string(),
            'address' => $this->string(),
            'file_id' => $this->integer(),
            'salary_int' => $this->float(),
            'salary_percent' => $this->float(),
        ]);

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-user_detail-user_id}}',
            '{{%user_detail}}',
            'user_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-user_detail-user_id}}',
            '{{%user_detail}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );

        // creates index for column `file_id`
        $this->createIndex(
            '{{%idx-user_detail-file_id}}',
            '{{%user_detail}}',
            'file_id'
        );

        // add foreign key for table `{{%file}}`
        $this->addForeignKey(
            '{{%fk-user_detail-file_id}}',
            '{{%user_detail}}',
            'file_id',
            '{{%file}}',
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
            '{{%fk-user_detail-user_id}}',
            '{{%user_detail}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-user_detail-user_id}}',
            '{{%user_detail}}'
        );

        // drops foreign key for table `{{%file}}`
        $this->dropForeignKey(
            '{{%fk-user_detail-file_id}}',
            '{{%user_detail}}'
        );

        // drops index for column `file_id`
        $this->dropIndex(
            '{{%idx-user_detail-file_id}}',
            '{{%user_detail}}'
        );

        $this->dropTable('{{%user_detail}}');
    }
}
