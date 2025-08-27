<?php

declare(strict_types=1);

require __DIR__ . DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'config.php';

use API\src\utilities\classes\DataLoader;
use Phinx\Seed\AbstractSeed;

class UsersSeeder extends AbstractSeed
{
    public function run(): void
    {
        $data_Loader = new DataLoader();
        // load users data
        $dataFilePath = $data_Loader->getData('usersData.php');

        // create users table
        $users = $this->table('users');
        $users->insert($dataFilePath)
            ->save();
    }
}
