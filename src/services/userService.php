<?php

namespace API\src\services;

use API\src\database\classes\Database_pdo;
use API\src\database\classes\Database_query;
use API\src\dto\LoginAttemptsDTO;
use API\src\dto\UserDTO;
use API\src\models\User;
use DateTime;
use Exception;
use PDO;
use Psr\Container\ContainerInterface;

final class UserService
{
    private Database_query $database_query;
    private  $database_pdo;

    public function __construct(ContainerInterface $container)
    {
        $this->database_pdo = $container->get(Database_pdo::class);
        $this->database_query = $container->get(Database_query::class);
    }

    public function getAllUsers(): array
    {
        try {
            $users = $this->database_query->read_data('SELECT * FROM `users`');
            $data = array();

            if ($users->num_rows > 0) {
                while ($row = $users->fetch_assoc()) {
                    $row['preferences'] = json_decode($row['preferences'], true);
                    $row['created_at'] = (new DateTime($row['created_at']))->format('Y-m-d\TH:i:s.u\Z');
                    $row['updated_at'] = $row['updated_at'] ? (new DateTime($row['updated_at']))->format('Y-m-d\TH:i:s.u\Z') : null;
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


    // register user
    /**
     * Get a user by their email address.
     *
     * @param string $email The email address of the user.
     * @return array The user data if found, or an empty array if not found.
     * @throws \RuntimeException If there is an error during the query.
     */
    public function getUserByEmail(string $email): array
    {
        try {
            $stmt = $this->database_pdo->prepare("SELECT * FROM `users` WHERE email = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $user = $stmt->fetch(\PDO::FETCH_ASSOC);

            return $user ?: [];
        } catch (\Exception $e) {
            throw new \RuntimeException('Failed to get user by email: ' . $e->getMessage(), 0, $e);
        }
    }
    /**
     * Create a new user in the database.
     *
     * @param UserDTO $data The user data transfer object containing user details.
     * @return int The ID of the newly created user.
     * @throws \RuntimeException If there is an error during user creation.
     */
    public function createUser(UserDTO $data): int
    {
        try {
            $hashedPassword = password_hash($data->getPassword(), PASSWORD_DEFAULT);
            $gender = $data->getGender() ? ucfirst(strtolower($data->getGender())) : 'Other';
            $userType = $data->getUserType() ? ucfirst(strtolower($data->getUserType())) : 'Student';

            $ipList = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'] ?? '');
            $ip = trim($ipList[0]) ?: ($_SERVER['REMOTE_ADDR'] ?? null);
            if (!$ip) {
                throw new \RuntimeException('IP address is not available.');
            }

            $sql = "INSERT INTO `users` 
        (first_name, last_name, email, phone, username, age, password, gender, status, account_type, user_type, is_verified, preferences, last_login, ip_address, created_at) 
        VALUES 
        (:first_name, :last_name, :email, :phone, :username, :age, :password, :gender, :status, :account_type, :user_type, :is_verified, :preferences, :last_login, :ip_address, NOW())";

            $stmt = $this->database_pdo->prepare($sql);

            // تخزين القيم المعقدة في متغيرات مؤقتة
            $firstName = $data->getFirstName();
            $lastName = $data->getLastName();
            $email = $data->getEmail();
            $phone = $data->getPhone();
            $username = $firstName . ' ' . $lastName;
            $age = $data->getAge();
            $status = $data->getStatus() ?? 'Inactive';
            $accountType = $data->getAccountType() ?? 'Normal';
            $isVerified = (int)($data->getIsVerified() ?? 0);
            $preferences = json_encode([
                'privacy_policy' => $data->getPrivacyPolicy() ?? false,
                'country_code'   => $data->getCountryCode() ?? null,
                'country_name'   => $data->getCountryName() ?? null,
            ], JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR);
            $lastLogin = date('Y-m-d H:i:s');

            // ربط المتغيرات
            $stmt->bindParam(':first_name', $firstName);
            $stmt->bindParam(':last_name', $lastName);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':phone', $phone);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':age', $age);
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->bindParam(':gender', $gender);
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':account_type', $accountType);
            $stmt->bindParam(':user_type', $userType);
            $stmt->bindParam(':is_verified', $isVerified, PDO::PARAM_INT);
            $stmt->bindParam(':preferences', $preferences);
            $stmt->bindParam(':last_login', $lastLogin);
            $stmt->bindParam(':ip_address', $ip);

            $stmt->execute();

            return (int)$this->database_pdo->lastInsertId();
        } catch (\Exception $e) {
            throw new \RuntimeException('Failed to create user: ' . $e->getMessage(), 0, $e);
        }
    }

    /**
     * Log a login attempt.
     *
     * @param LoginAttemptsDTO $data
     * @return void
     * @throws \RuntimeException
     */
    public function logLoginAttempt(LoginAttemptsDTO $data): void
    {
        try {
            $sql = "INSERT INTO login_attempts (user_id, email_entered, ip_address, user_agent, status, error_message, created_at)
                VALUES (:user_id, :email_entered, :ip_address, :user_agent, :status, :error_message, NOW())";

            $stmt = $this->database_pdo->prepare($sql);
            $stmt->execute([
                'user_id'       => $data->getUserId(),
                'email_entered' => $data->getEmailEntered(),
                'ip_address'    => $data->getIpAddress(),
                'user_agent'    => $data->getUserAgent(),
                'status'        => $data->getStatus(),
                'error_message' => $data->getErrorMessage(),
            ]);
        } catch (\Exception $e) {
            throw new \RuntimeException("Failed to log login attempt: " . $e->getMessage(), 0, $e);
        }
    }


    /**
     * Count recent failed login attempts by email or IP.
     *
     * @param string $email
     * @param string $ip
     * @param int $minutes الفترة الزمنية لحساب المحاولات داخلها
     * @return int
     */
    public function countRecentFailedAttempts(string $email, string $ip, int $minutes = 15): int
    {
        try {
            $sql = "SELECT COUNT(*) FROM login_attempts
                WHERE status = 'failure'
                AND (email_entered = :email OR ip_address = :ip)
                AND created_at >= (NOW() - INTERVAL :minutes MINUTE)";

            $stmt = $this->database_pdo->prepare($sql);
            $stmt->bindValue(':email', $email);
            $stmt->bindValue(':ip', $ip);
            $stmt->bindValue(':minutes', $minutes, \PDO::PARAM_INT);
            $stmt->execute();

            return (int)$stmt->fetchColumn();
        } catch (\Exception $e) {
            throw new \RuntimeException("Failed to count failed attempts: " . $e->getMessage(), 0, $e);
        }
    }

    // update user status
    /**
     * Update user status.
     *
     * @param int $userId
     * @param string $status
     * @return void
     */
    public function updateUserStatus(int $userId, string $status): void
    {
        try {
            $sql = "UPDATE users SET `status` = :user_status WHERE id = :id AND `status` != :user_status";
            $stmt = $this->database_pdo->prepare($sql);

            // Bind parameters
            $stmt->bindParam(':user_status', $status);
            $stmt->bindParam(':id', $userId);
            $stmt->execute();
        } catch (\Exception $e) {
            throw new \RuntimeException("Failed to update user status: " . $e->getMessage(), 0, $e);
        }
    }

    //update user last login
    /**
     * Update the last login time and IP address of a user.
     *
     * @param int $userId The ID of the user to update.
     * @return void
     * @throws \RuntimeException If there is an error during the update.
     */
    public function updateUserLastLogin(int $userId): void
    {
        try {
            $sql = "UPDATE users SET last_login = NOW(), last_ip_address = :last_ip_address WHERE id = :id";
            $stmt = $this->database_pdo->prepare($sql);
            $lastIpAddress = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'] ?? 'unknown';
            $stmt->bindParam(':last_ip_address', $lastIpAddress);
            $stmt->bindParam(':id', $userId);
            $stmt->execute();
        } catch (\Exception $e) {
            throw new \RuntimeException("Failed to update user last login: " . $e->getMessage(), 0, $e);
        }
    }
}
