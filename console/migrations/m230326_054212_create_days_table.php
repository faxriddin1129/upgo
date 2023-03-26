<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%days}}`.
 */
class m230326_054212_create_days_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%day}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
        ]);

        $this->insert('day',[
            'name' => 'Monday',
        ]);

        $this->insert('day',[
            'name' => 'Tuesday',
        ]);

        $this->insert('day',[
            'name' => 'Wednesday',
        ]);

        $this->insert('day',[
            'name' => 'Thursday',
        ]);

        $this->insert('day',[
            'name' => 'Friday',
        ]);
        $this->insert('day',[
            'name' => 'Saturday',
        ]);

        $this->insert('day',[
            'name' => 'Sunday',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%day}}');
    }
}
