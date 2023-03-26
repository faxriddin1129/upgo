<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%stock}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%user}}`
 * - `{{%user}}`
 * - `{{%user}}`
 */
class m230326_055901_create_stock_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%stock}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'user_id' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
        ]);

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-stock-user_id}}',
            '{{%stock}}',
            'user_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-stock-user_id}}',
            '{{%stock}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );

        // creates index for column `created_by`
        $this->createIndex(
            '{{%idx-stock-created_by}}',
            '{{%stock}}',
            'created_by'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-stock-created_by}}',
            '{{%stock}}',
            'created_by',
            '{{%user}}',
            'id',
            'CASCADE'
        );

        // creates index for column `updated_by`
        $this->createIndex(
            '{{%idx-stock-updated_by}}',
            '{{%stock}}',
            'updated_by'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-stock-updated_by}}',
            '{{%stock}}',
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
            '{{%fk-stock-user_id}}',
            '{{%stock}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-stock-user_id}}',
            '{{%stock}}'
        );

        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-stock-created_by}}',
            '{{%stock}}'
        );

        // drops index for column `created_by`
        $this->dropIndex(
            '{{%idx-stock-created_by}}',
            '{{%stock}}'
        );

        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-stock-updated_by}}',
            '{{%stock}}'
        );

        // drops index for column `updated_by`
        $this->dropIndex(
            '{{%idx-stock-updated_by}}',
            '{{%stock}}'
        );

        $this->dropTable('{{%stock}}');
    }
}
