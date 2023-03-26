<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%client}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%user}}`
 * - `{{%region}}`
 */
class m230325_081743_create_client_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%client}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'legal_name' => $this->string(),
            'name' => $this->string(),
            'address' => $this->text(),
            'location' => $this->text(),
            'nearby' => $this->string(),
            'region_id' => $this->integer(),
            'inn' => $this->string(),
            'file_id' => $this->integer(),
            'status' => $this->integer(),
            'deleted_description' => $this->text(),
        ]);

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-client-user_id}}',
            '{{%client}}',
            'user_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-client-user_id}}',
            '{{%client}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );

        // creates index for column `region_id`
        $this->createIndex(
            '{{%idx-client-region_id}}',
            '{{%client}}',
            'region_id'
        );

        // add foreign key for table `{{%region}}`
        $this->addForeignKey(
            '{{%fk-client-region_id}}',
            '{{%client}}',
            'region_id',
            '{{%region}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-client-user_id}}',
            '{{%client}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-client-user_id}}',
            '{{%client}}'
        );

        // drops foreign key for table `{{%region}}`
        $this->dropForeignKey(
            '{{%fk-client-region_id}}',
            '{{%client}}'
        );

        // drops index for column `region_id`
        $this->dropIndex(
            '{{%idx-client-region_id}}',
            '{{%client}}'
        );

        $this->dropTable('{{%client}}');
    }
}
