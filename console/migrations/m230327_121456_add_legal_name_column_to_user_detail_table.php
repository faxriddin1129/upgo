<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%user_detail}}`.
 */
class m230327_121456_add_legal_name_column_to_user_detail_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%user_detail}}', 'legal_name', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%user_detail}}', 'legal_name');
    }
}
