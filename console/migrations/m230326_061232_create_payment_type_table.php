<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%stock_payment_type}}`.
 */
class m230326_061232_create_payment_type_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%payment_type}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%payment_type}}');
    }
}
