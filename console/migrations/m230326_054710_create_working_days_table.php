<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%working_days}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%client}}`
 * - `{{%day}}`
 * - `{{%user}}`
 * - `{{%user}}`
 * - `{{%user}}`
 */
class m230326_054710_create_working_days_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%working_days}}', [
            'id' => $this->primaryKey(),
            'client_id' => $this->integer(),
            'day_id' => $this->integer(),
            'user_id' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
        ]);

        // creates index for column `client_id`
        $this->createIndex(
            '{{%idx-working_days-client_id}}',
            '{{%working_days}}',
            'client_id'
        );

        // add foreign key for table `{{%client}}`
        $this->addForeignKey(
            '{{%fk-working_days-client_id}}',
            '{{%working_days}}',
            'client_id',
            '{{%client}}',
            'id',
            'CASCADE'
        );

        // creates index for column `day_id`
        $this->createIndex(
            '{{%idx-working_days-day_id}}',
            '{{%working_days}}',
            'day_id'
        );

        // add foreign key for table `{{%day}}`
        $this->addForeignKey(
            '{{%fk-working_days-day_id}}',
            '{{%working_days}}',
            'day_id',
            '{{%day}}',
            'id',
            'CASCADE'
        );

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-working_days-user_id}}',
            '{{%working_days}}',
            'user_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-working_days-user_id}}',
            '{{%working_days}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );

        // creates index for column `created_by`
        $this->createIndex(
            '{{%idx-working_days-created_by}}',
            '{{%working_days}}',
            'created_by'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-working_days-created_by}}',
            '{{%working_days}}',
            'created_by',
            '{{%user}}',
            'id',
            'CASCADE'
        );

        // creates index for column `updated_by`
        $this->createIndex(
            '{{%idx-working_days-updated_by}}',
            '{{%working_days}}',
            'updated_by'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-working_days-updated_by}}',
            '{{%working_days}}',
            'updated_by',
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
        // drops foreign key for table `{{%client}}`
        $this->dropForeignKey(
            '{{%fk-working_days-client_id}}',
            '{{%working_days}}'
        );

        // drops index for column `client_id`
        $this->dropIndex(
            '{{%idx-working_days-client_id}}',
            '{{%working_days}}'
        );

        // drops foreign key for table `{{%day}}`
        $this->dropForeignKey(
            '{{%fk-working_days-day_id}}',
            '{{%working_days}}'
        );

        // drops index for column `day_id`
        $this->dropIndex(
            '{{%idx-working_days-day_id}}',
            '{{%working_days}}'
        );

        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-working_days-user_id}}',
            '{{%working_days}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-working_days-user_id}}',
            '{{%working_days}}'
        );

        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-working_days-created_by}}',
            '{{%working_days}}'
        );

        // drops index for column `created_by`
        $this->dropIndex(
            '{{%idx-working_days-created_by}}',
            '{{%working_days}}'
        );

        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-working_days-updated_by}}',
            '{{%working_days}}'
        );

        // drops index for column `updated_by`
        $this->dropIndex(
            '{{%idx-working_days-updated_by}}',
            '{{%working_days}}'
        );

        $this->dropTable('{{%working_days}}');
    }
}
