<?php

namespace API\src\services;

use API\src\models\User;
use Exception;

final class UserService
{
    private $database_query;
    private $database_pdo;

    public function __construct($database_pdo, $database_query)
    {
        $this->database_pdo = $database_pdo;
        $this->database_query = $database_query;
    }

    public function getAllUsers(): array
    {
        try {
            $users = $this->database_query->read_data('SELECT * FROM `users`');
            $data = array();

            if ($users->num_rows > 0) {
                while ($row = $users->fetch_assoc()) {
                    $row['preferences'] = json_decode($row['preferences'], true);
                    $row['created_at'] = (new \DateTime($row['created_at']))->format('Y-m-d\TH:i:s.u\Z');
                    $row['updated_at'] = $row['updated_at'] ? (new \DateTime($row['updated_at']))->format('Y-m-d\TH:i:s.u\Z') : null;
                    $data[] = $row;
                }
            }

            return $data;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function getUserById($id): array
    {
        try {
            $stmt = $this->database_pdo->prepare("SELECT * FROM `users` WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $user = $stmt->fetch();
            if ($user) {
                $user['preferences'] = json_decode($user['preferences'], true);
                $user['created_at'] = (new \DateTime($user['created_at']))->format('Y-m-d\TH:i:s.u\Z');
                $user['updated_at'] = $user['updated_at'] ? (new \DateTime($user['updated_at']))->format('Y-m-d\TH:i:s.u\Z') : null;
            }
            return $user;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function getUsersByPage(int $page, int $limit = 10): array
    {
        try {
            $offset = ($page - 1) * $limit;
            $users = User::skip($offset)->take($limit)->get();

            // Convert the Eloquent collection to an array
            $userArray = $users->map(function ($user) {
                $user->created_at = (new \DateTime($user->created_at))->format('Y-m-d\TH:i:s.u\Z');
                $user->updated_at = $user->updated_at ? (new \DateTime($user->updated_at))->format('Y-m-d\TH:i:s.u\Z') : null;

                // Convert individual user model to array
                return $user->toArray();
            })->toArray(); // Convert the collection to array

            return $userArray;
        } catch (Exception $e) {
            throw $e;
        }
    }
}
