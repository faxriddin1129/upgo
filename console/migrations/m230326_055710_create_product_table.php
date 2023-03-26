<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%product}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%file}}`
 * - `{{%measure}}`
 * - `{{%category}}`
 * - `{{%user}}`
 * - `{{%user}}`
 */
class m230326_055710_create_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%product}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'get_price' => $this->float(),
            'sell_price' => $this->float(),
            'file_id' => $this->integer(),
            'measure_id' => $this->integer(),
            'category_id' => $this->integer(),
            'description' => $this->text(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
        ]);

        // creates index for column `file_id`
        $this->createIndex(
            '{{%idx-product-file_id}}',
            '{{%product}}',
            'file_id'
        );

        // add foreign key for table `{{%file}}`
        $this->addForeignKey(
            '{{%fk-product-file_id}}',
            '{{%product}}',
            'file_id',
            '{{%file}}',
            'id',
            'CASCADE'
        );

        // creates index for column `measure_id`
        $this->createIndex(
            '{{%idx-product-measure_id}}',
            '{{%product}}',
            'measure_id'
        );

        // add foreign key for table `{{%measure}}`
        $this->addForeignKey(
            '{{%fk-product-measure_id}}',
            '{{%product}}',
            'measure_id',
            '{{%measure}}',
            'id',
            'CASCADE'
        );

        // creates index for column `category_id`
        $this->createIndex(
            '{{%idx-product-category_id}}',
            '{{%product}}',
            'category_id'
        );

        // add foreign key for table `{{%category}}`
        $this->addForeignKey(
            '{{%fk-product-category_id}}',
            '{{%product}}',
            'category_id',
            '{{%category}}',
            'id',
            'CASCADE'
        );

        // creates index for column `created_by`
        $this->createIndex(
            '{{%idx-product-created_by}}',
            '{{%product}}',
            'created_by'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-product-created_by}}',
            '{{%product}}',
            'created_by',
            '{{%user}}',
            'id',
            'CASCADE'
        );

        // creates index for column `updated_by`
        $this->createIndex(
            '{{%idx-product-updated_by}}',
            '{{%product}}',
            'updated_by'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-product-updated_by}}',
            '{{%product}}',
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
        // drops foreign key for table `{{%file}}`
        $this->dropForeignKey(
            '{{%fk-product-file_id}}',
            '{{%product}}'
        );

        // drops index for column `file_id`
        $this->dropIndex(
            '{{%idx-product-file_id}}',
            '{{%product}}'
        );

        // drops foreign key for table `{{%measure}}`
        $this->dropForeignKey(
            '{{%fk-product-measure_id}}',
            '{{%product}}'
        );

        // drops index for column `measure_id`
        $this->dropIndex(
            '{{%idx-product-measure_id}}',
            '{{%product}}'
        );

        // drops foreign key for table `{{%category}}`
        $this->dropForeignKey(
            '{{%fk-product-category_id}}',
            '{{%product}}'
        );

        // drops index for column `category_id`
        $this->dropIndex(
            '{{%idx-product-category_id}}',
            '{{%product}}'
        );

        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-product-created_by}}',
            '{{%product}}'
        );

        // drops index for column `created_by`
        $this->dropIndex(
            '{{%idx-product-created_by}}',
            '{{%product}}'
        );

        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-product-updated_by}}',
            '{{%product}}'
        );

        // drops index for column `updated_by`
        $this->dropIndex(
            '{{%idx-product-updated_by}}',
            '{{%product}}'
        );

        $this->dropTable('{{%product}}');
    }
}
