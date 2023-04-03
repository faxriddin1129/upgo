<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%product}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%user}}`
 */
class m230402_070706_add_user_id_column_to_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%product}}', 'user_id', $this->integer());
        $this->addColumn('{{%product}}', 'status', $this->smallInteger());

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-product-user_id}}',
            '{{%product}}',
            'user_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-product-user_id}}',
            '{{%product}}',
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
            '{{%fk-product-user_id}}',
            '{{%product}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-product-user_id}}',
            '{{%product}}'
        );

        $this->dropColumn('{{%product}}', 'user_id');
    }
}
