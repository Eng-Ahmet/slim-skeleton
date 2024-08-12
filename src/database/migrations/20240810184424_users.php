<?php

declare(strict_types=1);

require_once __DIR__ . '/../../../config.php';
require APP_PATH . DS . "autoload.php";

use Phinx\Migration\AbstractMigration;

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
 * 
 * for create table use this template
 * vendor/bin/phinx create Users 
 * for upload table to db run:
 *  vendor/bin/phinx migrate 
 */
final class Users extends AbstractMigration
{
    public function change(): void
    {
        if ($this->hasTable('users')) {
            $this->table('users')->drop()->save();
        }

        // create table
        $table = $this->table('users');
        $table
            ->addColumn('first_name', 'string', ['limit' => 50, 'null' => false])
            ->addColumn('last_name', 'string', ['limit' => 100, 'null' => false])
            ->addColumn('email', 'string', ['limit' => 100, 'null' => false])
            ->addColumn('phone', 'string', ['limit' => 15, 'null' => false])
            ->addColumn('username', 'string', ['limit' => 20, 'null' => false])
            ->addIndex('email', ['unique' => true])
            ->addColumn('password', 'string', ['null' => false])
            ->addColumn('gender', 'enum', ['values' => ['Male', 'Female', 'Other'], 'default' => 'Other', 'null' => false])
            ->addColumn('status', 'enum', ['values' => ['Active', 'Inactive', 'Suspended', 'Blocked', 'Deleted', 'Pending'], 'default' => 'Inactive', 'null' => false])
            ->addColumn('account_type', 'enum', ['values' => ['VIP', 'Normal'], 'default' => 'Normal', 'null' => false])
            ->addColumn('login_attempts', 'integer', ['default' => 0, 'null' => false])
            ->addColumn('preferences', 'json', ['null' => true])
            ->addColumn('created_at', 'datetime')
            ->addColumn('updated_at', 'datetime', ['null' => true])
            ->create();
    }

    public function up(): void
    {
        // delete table if exists
        if ($this->hasTable('users')) {
            $this->table('users')->drop()->save();
        }

        // create table
        $this->change();
    }

    public function down(): void
    {
        // delete table
        if ($this->hasTable('users')) {
            $this->table('users')->drop()->save();
        }
    }
}
