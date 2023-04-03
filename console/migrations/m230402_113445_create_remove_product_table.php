<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%remove_product}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%product}}`
 * - `{{%stock}}`
 * - `{{%user}}`
 * - `{{%user}}`
 */
class m230402_113445_create_remove_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%remove_product}}', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer(),
            'count' => $this->integer(),
            'stock_id' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
        ]);

        // creates index for column `product_id`
        $this->createIndex(
            '{{%idx-remove_product-product_id}}',
            '{{%remove_product}}',
            'product_id'
        );

        // add foreign key for table `{{%product}}`
        $this->addForeignKey(
            '{{%fk-remove_product-product_id}}',
            '{{%remove_product}}',
            'product_id',
            '{{%product}}',
            'id',
            'CASCADE'
        );

        // creates index for column `stock_id`
        $this->createIndex(
            '{{%idx-remove_product-stock_id}}',
            '{{%remove_product}}',
            'stock_id'
        );

        // add foreign key for table `{{%stock}}`
        $this->addForeignKey(
            '{{%fk-remove_product-stock_id}}',
            '{{%remove_product}}',
            'stock_id',
            '{{%stock}}',
            'id',
            'CASCADE'
        );

        // creates index for column `created_by`
        $this->createIndex(
            '{{%idx-remove_product-created_by}}',
            '{{%remove_product}}',
            'created_by'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-remove_product-created_by}}',
            '{{%remove_product}}',
            'created_by',
            '{{%user}}',
            'id',
            'CASCADE'
        );

        // creates index for column `updated_by`
        $this->createIndex(
            '{{%idx-remove_product-updated_by}}',
            '{{%remove_product}}',
            'updated_by'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-remove_product-updated_by}}',
            '{{%remove_product}}',
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
        // drops foreign key for table `{{%product}}`
        $this->dropForeignKey(
            '{{%fk-remove_product-product_id}}',
            '{{%remove_product}}'
        );

        // drops index for column `product_id`
        $this->dropIndex(
            '{{%idx-remove_product-product_id}}',
            '{{%remove_product}}'
        );

        // drops foreign key for table `{{%stock}}`
        $this->dropForeignKey(
            '{{%fk-remove_product-stock_id}}',
            '{{%remove_product}}'
        );

        // drops index for column `stock_id`
        $this->dropIndex(
            '{{%idx-remove_product-stock_id}}',
            '{{%remove_product}}'
        );

        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-remove_product-created_by}}',
            '{{%remove_product}}'
        );

        // drops index for column `created_by`
        $this->dropIndex(
            '{{%idx-remove_product-created_by}}',
            '{{%remove_product}}'
        );

        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-remove_product-updated_by}}',
            '{{%remove_product}}'
        );

        // drops index for column `updated_by`
        $this->dropIndex(
            '{{%idx-remove_product-updated_by}}',
            '{{%remove_product}}'
        );

        $this->dropTable('{{%remove_product}}');
    }
}
