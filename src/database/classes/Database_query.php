<?php

declare(strict_types=1);

namespace API\src\database\classes;

use Exception;

class Database_query
{
    public $servername;
    public $username;
    public $password;
    public $db;
    public $conn;
    public $string;

    function __construct()
    {

        // Load database settings
        $settings =  require_once APP_PATH . DS . "src" . DS . "database" . DS . "config" . DS . "db_query_setting.php";

        if (!isset($settings['settings']['db'])) {
            throw new \Exception("Database settings array is missing or incomplete.");
        }
        $dbSettings = $settings['settings']['db'];

        // Create connection
        $this->servername = $dbSettings['host'];
        $this->username = $dbSettings['username'];
        $this->password = $dbSettings['password'];
        $this->db = $dbSettings['database'];
    }

    function read_data($sql)
    {
        $this->conn = mysqli_connect($this->servername, $this->username, $this->password, $this->db);

        // Check connection
        if (!$this->conn) {
            die("Connection failed: " . mysqli_connect_error());
        } else {
            // Set charset
            mysqli_set_charset($this->conn, "utf8mb4");
        }

        try {
            $result = mysqli_query($this->conn, $sql);
            $this->conn->close();
            return $result;
        } catch (Exception $e) {
            //echo "Message -> " . $e->getMessage();
            $this->conn->close();
        }
    }

    function exceute_data($sql)
    {
        $this->conn = mysqli_connect($this->servername, $this->username, $this->password, $this->db);

        // Check connection
        if (!$this->conn) {
            die("Connection failed: " . mysqli_connect_error());
        } else {
            // Set charset
            mysqli_set_charset($this->conn, "utf8mb4");
        }

        try {
            $result = mysqli_query($this->conn, $sql);
            $this->conn->close();

            return true;
        } catch (Exception $e) {
            // echo "Message -> " . $e->getMessage(); 
            $this->conn->close();

            return false;
        }
    }
}
