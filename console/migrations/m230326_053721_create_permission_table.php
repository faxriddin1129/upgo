<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%permission}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%user}}`
 */
class m230326_053721_create_permission_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%permission}}', [
            'id' => $this->primaryKey(),
            'name' => $this->text(),
            'action_id' => $this->string(),
        ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%permission}}');
    }
}
