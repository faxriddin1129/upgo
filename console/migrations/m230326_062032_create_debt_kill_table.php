<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%debt_kill}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%order}}`
 * - `{{%user}}`
 * - `{{%user}}`
 */
class m230326_062032_create_debt_kill_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%debt_kill}}', [
            'id' => $this->primaryKey(),
            'order_id' => $this->integer(),
            'debt_price' => $this->float(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
        ]);

        // creates index for column `order_id`
        $this->createIndex(
            '{{%idx-debt_kill-order_id}}',
            '{{%debt_kill}}',
            'order_id'
        );

        // add foreign key for table `{{%order}}`
        $this->addForeignKey(
            '{{%fk-debt_kill-order_id}}',
            '{{%debt_kill}}',
            'order_id',
            '{{%order}}',
            'id',
            'CASCADE'
        );

        // creates index for column `created_by`
        $this->createIndex(
            '{{%idx-debt_kill-created_by}}',
            '{{%debt_kill}}',
            'created_by'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-debt_kill-created_by}}',
            '{{%debt_kill}}',
            'created_by',
            '{{%user}}',
            'id',
            'CASCADE'
        );

        // creates index for column `updated_by`
        $this->createIndex(
            '{{%idx-debt_kill-updated_by}}',
            '{{%debt_kill}}',
            'updated_by'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-debt_kill-updated_by}}',
            '{{%debt_kill}}',
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
        // drops foreign key for table `{{%order}}`
        $this->dropForeignKey(
            '{{%fk-debt_kill-order_id}}',
            '{{%debt_kill}}'
        );

        // drops index for column `order_id`
        $this->dropIndex(
            '{{%idx-debt_kill-order_id}}',
            '{{%debt_kill}}'
        );

        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-debt_kill-created_by}}',
            '{{%debt_kill}}'
        );

        // drops index for column `created_by`
        $this->dropIndex(
            '{{%idx-debt_kill-created_by}}',
            '{{%debt_kill}}'
        );

        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-debt_kill-updated_by}}',
            '{{%debt_kill}}'
        );

        // drops index for column `updated_by`
        $this->dropIndex(
            '{{%idx-debt_kill-updated_by}}',
            '{{%debt_kill}}'
        );

        $this->dropTable('{{%debt_kill}}');
    }
}
