<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%order}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%client}}`
 * - `{{%user}}`
 * - `{{%payment_type}}`
 * - `{{%user}}`
 * - `{{%user}}`
 */
class m230326_061238_create_order_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%order}}', [
            'id' => $this->primaryKey(),
            'client_id' => $this->integer(),
            'user_id' => $this->integer(),
            'payment_type_id' => $this->integer(),
            'cashback' => $this->integer(),
            'delivery_time' => $this->integer(),
            'total_price' => $this->float(),
            'debt' => $this->float(),
            'pay_status' => $this->integer(),
            'get_price' => $this->float(),
            'status' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
        ]);

        // creates index for column `client_id`
        $this->createIndex(
            '{{%idx-order-client_id}}',
            '{{%order}}',
            'client_id'
        );

        // add foreign key for table `{{%client}}`
        $this->addForeignKey(
            '{{%fk-order-client_id}}',
            '{{%order}}',
            'client_id',
            '{{%client}}',
            'id',
            'CASCADE'
        );

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-order-user_id}}',
            '{{%order}}',
            'user_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-order-user_id}}',
            '{{%order}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );

        // creates index for column `payment_type_id`
        $this->createIndex(
            '{{%idx-order-payment_type_id}}',
            '{{%order}}',
            'payment_type_id'
        );

        // add foreign key for table `{{%payment_type}}`
        $this->addForeignKey(
            '{{%fk-order-payment_type_id}}',
            '{{%order}}',
            'payment_type_id',
            '{{%payment_type}}',
            'id',
            'CASCADE'
        );

        // creates index for column `created_by`
        $this->createIndex(
            '{{%idx-order-created_by}}',
            '{{%order}}',
            'created_by'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-order-created_by}}',
            '{{%order}}',
            'created_by',
            '{{%user}}',
            'id',
            'CASCADE'
        );

        // creates index for column `updated_by`
        $this->createIndex(
            '{{%idx-order-updated_by}}',
            '{{%order}}',
            'updated_by'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-order-updated_by}}',
            '{{%order}}',
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
            '{{%fk-order-client_id}}',
            '{{%order}}'
        );

        // drops index for column `client_id`
        $this->dropIndex(
            '{{%idx-order-client_id}}',
            '{{%order}}'
        );

        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-order-user_id}}',
            '{{%order}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-order-user_id}}',
            '{{%order}}'
        );

        // drops foreign key for table `{{%payment_type}}`
        $this->dropForeignKey(
            '{{%fk-order-payment_type_id}}',
            '{{%order}}'
        );

        // drops index for column `payment_type_id`
        $this->dropIndex(
            '{{%idx-order-payment_type_id}}',
            '{{%order}}'
        );

        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-order-created_by}}',
            '{{%order}}'
        );

        // drops index for column `created_by`
        $this->dropIndex(
            '{{%idx-order-created_by}}',
            '{{%order}}'
        );

        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-order-updated_by}}',
            '{{%order}}'
        );

        // drops index for column `updated_by`
        $this->dropIndex(
            '{{%idx-order-updated_by}}',
            '{{%order}}'
        );

        $this->dropTable('{{%order}}');
    }
}
