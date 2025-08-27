<?php

declare(strict_types=1);

namespace API\src\database\classes;

use API\src\utilities\classes\EnvReader;
use Exception;

class Database_query
{
    public $servername;
    public $username;
    public $password;
    public $db;
    public $conn;

    function __construct()
    {
        $env = new EnvReader(APP_PATH . '/.env');

        $this->servername = $env->getValue('DB_HOST');
        $this->username = $env->getValue('DB_USER');
        $this->password = $env->getValue('DB_PASSWORD');
        $this->db = $env->getValue('DB_NAME');
    }

    function read_data($sql)
    {
        $this->conn = mysqli_connect($this->servername, $this->username, $this->password, $this->db);

        if (!$this->conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        mysqli_set_charset($this->conn, "utf8mb4");

        try {
            $result = mysqli_query($this->conn, $sql);
            $this->conn->close();
            return $result;
        } catch (Exception $e) {
            $this->conn->close();
        }
    }

    function exceute_data($sql)
    {
        $this->conn = mysqli_connect($this->servername, $this->username, $this->password, $this->db);

        if (!$this->conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        mysqli_set_charset($this->conn, "utf8mb4");

        try {
            $result = mysqli_query($this->conn, $sql);
            $this->conn->close();
            return true;
        } catch (Exception $e) {
            $this->conn->close();
            return false;
        }
    }
}
