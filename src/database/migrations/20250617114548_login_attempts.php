<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class LoginAttempts extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change(): void
    {
        if ($this->hasTable('login_attempts')) {
            $this->table('login_attempts')->drop()->save();
        }

        $table = $this->table('login_attempts');
        $table
            ->addColumn('user_id', 'integer', ['null' => false, 'signed' => false])
            ->addColumn('email_entered', 'string', ['limit' => 100, 'null' => false])
            ->addColumn('ip_address', 'string', ['limit' => 50, 'null' => false])
            ->addColumn('user_agent', 'string', ['limit' => 255, 'null' => true])
            ->addColumn('status', 'enum', ['values' => ['success', 'failure'], 'default' => 'failure'])
            ->addColumn('error_message', 'string', ['limit' => 255, 'null' => true])
            ->addColumn('created_at', 'datetime', ['default' => 'CURRENT_TIMESTAMP'])
            ->addForeignKey('user_id', 'users', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
            ->create();
    }

    public function up(): void
    {
        // delete table if exists
        if ($this->hasTable('login_attempts')) {
            $this->table('login_attempts')->drop()->save();
        }

        // create table
        $this->change();
    }

    public function down(): void
    {
        // delete table
        if ($this->hasTable('login_attempts')) {
            $this->table('login_attempts')->drop()->save();
        }
    }
}
