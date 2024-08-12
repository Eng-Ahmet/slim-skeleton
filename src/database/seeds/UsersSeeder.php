<?php

declare(strict_types=1);

require_once __DIR__ . '/../../../config.php';
require APP_PATH . DS . "autoload.php";

use API\src\utilities\classes\Data_Loader;
use Phinx\Seed\AbstractSeed;

class UsersSeeder extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available هنا:
     * https://book.cakephp.org/phinx/0/en/seeding.html
     */

    // php vendor/bin/phinx seed:run
    // vendor/bin/phinx seed:run --seed=UsersSeeder

    public function run(): void
    {
        $data_Loader = new Data_Loader();
        // require users data
        $dataFilePath = $data_Loader->getData('usersData.php');

        //create users table
        $users = $this->table('users');
        $users->insert($dataFilePath)
            ->save();
    }
}
