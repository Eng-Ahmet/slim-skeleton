<?php

declare(strict_types=1);

namespace API\src\variables;

use API\src\utilities\classes\Encrypt;

$Encrypt = new Encrypt();

return [
    [
        'first_name' => 'John',
        'last_name' => 'Doe',
        'email' => $Encrypt->encryptData('johndoe@example.com'),
        'phone' => '1234567890',
        'username' => 'johndoe',
        'password' => $Encrypt->encryptData("password123"),
        'gender' => 'Male',
        'status' => 'Active',
        'account_type' => 'Normal',
        'login_attempts' => 1,
        'preferences' => json_encode(['theme' => 'dark', 'language' => 'en']),
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s'),
    ],
    [
        'first_name' => 'Jane',
        'last_name' => 'Doe',
        'email' => $Encrypt->encryptData('janedoe@example.com'),
        'phone' => '0987654321',
        'username' => 'janedoe',
        'password' => $Encrypt->encryptData("password123"),
        'gender' => 'Female',
        'status' => 'Inactive',
        'account_type' => 'VIP',
        'login_attempts' => 0,
        'preferences' => json_encode(['theme' => 'light', 'language' => 'fr']),
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s'),
    ],
    [
        'first_name' => 'Alice',
        'last_name' => 'Smith',
        'email' => $Encrypt->encryptData('alicesmith@example.com'),
        'phone' => '5555555555',
        'username' => 'alicesmith',
        'password' => $Encrypt->encryptData("password123"),
        'gender' => 'Female',
        'status' => 'Suspended',
        'account_type' => 'Normal',
        'login_attempts' => 3,
        'preferences' => json_encode(['theme' => 'dark', 'language' => 'es']),
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s'),
    ],
    [
        'first_name' => 'Bob',
        'last_name' => 'Johnson',
        'email' => $Encrypt->encryptData('bobjohnson@example.com'),
        'phone' => '6666666666',
        'username' => 'bobjohnson',
        'password' => $Encrypt->encryptData("password123"),
        'gender' => 'Male',
        'status' => 'Pending',
        'account_type' => 'Normal',
        'login_attempts' => 2,
        'preferences' => json_encode(['theme' => 'light', 'language' => 'de']),
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s'),
    ]
];
