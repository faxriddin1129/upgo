<?php

use common\models\User;
use yii\db\Migration;

class m130524_201442_init extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%file}}',[
            'id' => $this->primaryKey(),
            'url' => $this->text(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer()
        ]);

        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password' => $this->string()->notNull(),
            'password_reset_token' => $this->string(),
            'token' => $this->string(),
            'role' => $this->smallInteger(),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'parent_id' => $this->integer()
        ], $tableOptions);

        $this->insert('user',[
            'username' => '+998907291129',
            'password_hash' => Yii::$app->security->generatePasswordHash('+998907291129'),
            'password' => '+998907291129',
            'token' => Yii::$app->security->generateRandomString(),
            'auth_key' => Yii::$app->security->generateRandomString(),
            'role' => User::ROLE_ADMIN,
            'status' => User::STATUS_ACTIVE,
            'created_at' => time(),
            'updated_at' => time(),
        ]);

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-user-parent_id}}',
            '{{%user}}',
            'parent_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-user-parent_id}}',
            '{{%user}}',
            'parent_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );

    }



    public function down()
    {

        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-user_parent_id}}',
            '{{%user}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-user-parent_id}}',
            '{{%user}}'
        );

        $this->dropTable('{{%user}}');

        $this->dropTable('{{%file}}');
    }
}
