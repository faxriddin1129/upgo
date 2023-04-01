<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%client}}`.
 */
class m230329_075551_add_phone_full_name_column_to_client_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%client}}', 'phone', $this->string());
        $this->addColumn('{{%client}}', 'full_name', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%client}}', 'phone');
        $this->dropColumn('{{%client}}', 'full_name');
    }
}
