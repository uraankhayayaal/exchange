<?php

use yii\db\Migration;

/**
 * Class m230729_151893_create_user_refresh_token_table
 */
final class m230729_151893_create_user_refresh_token_table extends Migration
{
    /**
     * @inheritDoc
     */
    public function safeUp(): void
    {
        $this->createTable('{{%user_refresh_token}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'refresh_token' => $this->string()->notNull(),
            'expired_at' => $this->integer()->unsigned()->notNull(),
            'created_at' => $this->integer()->unsigned(),
            'updated_at' => $this->integer()->unsigned(),
        ]);

        $this->createIndex('user_refresh_token_user_id_index', '{{%user_refresh_token}}', 'user_id');

        $this->addForeignKey('user_refresh_token_user_id_foreign', '{{%user_refresh_token}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE');

        $this->createIndex('user_refresh_token_refresh_token_index', '{{%user_refresh_token}}', 'refresh_token', true);
    }

    /**
     * @inheritDoc
     */
    public function safeDown(): void
    {
        $this->dropTable('{{%user_refresh_token}}');
    }
}
