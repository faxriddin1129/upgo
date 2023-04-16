<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%order}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%user}}`
 */
class m230416_110516_add_diller_id_column_to_order_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%order}}', 'diller_id', $this->integer());

        // creates index for column `diller_id`
        $this->createIndex(
            '{{%idx-order-diller_id}}',
            '{{%order}}',
            'diller_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-order-diller_id}}',
            '{{%order}}',
            'diller_id',
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
            '{{%fk-order-diller_id}}',
            '{{%order}}'
        );

        // drops index for column `diller_id`
        $this->dropIndex(
            '{{%idx-order-diller_id}}',
            '{{%order}}'
        );

        $this->dropColumn('{{%order}}', 'diller_id');
    }
}
