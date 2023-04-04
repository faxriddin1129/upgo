<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%remove_product}}`.
 */
class m230404_115750_add_comment_column_to_remove_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%remove_product}}', 'comment', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%remove_product}}', 'comment');
    }
}
