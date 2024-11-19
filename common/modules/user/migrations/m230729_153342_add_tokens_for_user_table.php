<?php

use yii\db\Migration;

/**
 * Class m230729_153342_add_tokens_for_user_table
 */
class m230729_153342_add_tokens_for_user_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%user}}', 'email_confirm_token', $this->string());
        $this->createIndex('user_email_confirm_token_unique', '{{%user}}', 'email_confirm_token', true);
    }

    public function safeDown()
    {
        $this->dropColumn('{{%user}}', 'email_confirm_token');
    }
}
