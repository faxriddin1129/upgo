<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%stock_product}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%product}}`
 * - `{{%user}}`
 * - `{{%user}}`
 * - `{{%stock}}`
 */
class m230326_060237_create_stock_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%stock_product}}', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer(),
            'count' => $this->float(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
            'stock_id' => $this->integer(),
        ]);

        // creates index for column `product_id`
        $this->createIndex(
            '{{%idx-stock_product-product_id}}',
            '{{%stock_product}}',
            'product_id'
        );

        // add foreign key for table `{{%product}}`
        $this->addForeignKey(
            '{{%fk-stock_product-product_id}}',
            '{{%stock_product}}',
            'product_id',
            '{{%product}}',
            'id',
            'CASCADE'
        );

        // creates index for column `created_by`
        $this->createIndex(
            '{{%idx-stock_product-created_by}}',
            '{{%stock_product}}',
            'created_by'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-stock_product-created_by}}',
            '{{%stock_product}}',
            'created_by',
            '{{%user}}',
            'id',
            'CASCADE'
        );

        // creates index for column `updated_by`
        $this->createIndex(
            '{{%idx-stock_product-updated_by}}',
            '{{%stock_product}}',
            'updated_by'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-stock_product-updated_by}}',
            '{{%stock_product}}',
            'updated_by',
            '{{%user}}',
            'id',
            'CASCADE'
        );

        // creates index for column `stock_id`
        $this->createIndex(
            '{{%idx-stock_product-stock_id}}',
            '{{%stock_product}}',
            'stock_id'
        );

        // add foreign key for table `{{%stock}}`
        $this->addForeignKey(
            '{{%fk-stock_product-stock_id}}',
            '{{%stock_product}}',
            'stock_id',
            '{{%stock}}',
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
            '{{%fk-stock_product-product_id}}',
            '{{%stock_product}}'
        );

        // drops index for column `product_id`
        $this->dropIndex(
            '{{%idx-stock_product-product_id}}',
            '{{%stock_product}}'
        );

        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-stock_product-created_by}}',
            '{{%stock_product}}'
        );

        // drops index for column `created_by`
        $this->dropIndex(
            '{{%idx-stock_product-created_by}}',
            '{{%stock_product}}'
        );

        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-stock_product-updated_by}}',
            '{{%stock_product}}'
        );

        // drops index for column `updated_by`
        $this->dropIndex(
            '{{%idx-stock_product-updated_by}}',
            '{{%stock_product}}'
        );

        // drops foreign key for table `{{%stock}}`
        $this->dropForeignKey(
            '{{%fk-stock_product-stock_id}}',
            '{{%stock_product}}'
        );

        // drops index for column `stock_id`
        $this->dropIndex(
            '{{%idx-stock_product-stock_id}}',
            '{{%stock_product}}'
        );

        $this->dropTable('{{%stock_product}}');
    }
}
