<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%measure}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%user}}`
 * - `{{%user}}`
 */
class m230326_055231_create_measure_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%measure}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
            'diller_id' => $this->integer(),
        ]);

        // creates index for column `created_by`
        $this->createIndex(
            '{{%idx-measure-created_by}}',
            '{{%measure}}',
            'created_by'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-measure-created_by}}',
            '{{%measure}}',
            'created_by',
            '{{%user}}',
            'id',
            'CASCADE'
        );

        // creates index for column `updated_by`
        $this->createIndex(
            '{{%idx-measure-updated_by}}',
            '{{%measure}}',
            'updated_by'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-measure-updated_by}}',
            '{{%measure}}',
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
        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-measure-created_by}}',
            '{{%measure}}'
        );

        // drops index for column `created_by`
        $this->dropIndex(
            '{{%idx-measure-created_by}}',
            '{{%measure}}'
        );

        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-measure-updated_by}}',
            '{{%measure}}'
        );

        // drops index for column `updated_by`
        $this->dropIndex(
            '{{%idx-measure-updated_by}}',
            '{{%measure}}'
        );

        $this->dropTable('{{%measure}}');
    }
}
