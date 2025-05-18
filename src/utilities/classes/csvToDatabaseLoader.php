<?php

declare(strict_types=1);

namespace API\src\utilities\classes;

use Exception;

class CsvToDatabaseLoader
{
    public $servername;
    public $username;
    public $password;
    public $db;
    public $conn;

    function __construct()
    {
        // Load database settings from external config file
        $settings = require_once APP_PATH . DS . "src" . DS . "database" . DS . "config" . DS . "db_query_setting.php";

        if (!isset($settings['settings']['db'])) {
            throw new Exception("Database settings array is missing or incomplete.");
        }
        $dbSettings = $settings['settings']['db'];

        // Set database credentials
        $this->servername = $dbSettings['host'];
        $this->username = $dbSettings['username'];
        $this->password = $dbSettings['password'];
        $this->db = $dbSettings['database'];

        // Create connection
        $this->conn = mysqli_connect($this->servername, $this->username, $this->password, $this->db);

        // Check connection
        if (!$this->conn) {
            die("Connection failed: " . mysqli_connect_error());
        } else {
            // Set charset
            mysqli_set_charset($this->conn, "utf8mb4");
        }
    }

    /**
     * Load data from a CSV or TSV file into the specified table
     *
     * @param string $filePath   Path to the CSV or TSV file
     * @param string $tableName  Name of the target database table
     * @param string $delimiter  Delimiter used in the file (',' for CSV, '\t' for TSV)
     * @return void
     */
    public function loadDataFromFile(string $filePath, string $tableName, string $delimiter = ','): void
    {
        // SQL query to load data into the table
        $sql = sprintf(
            "LOAD DATA INFILE '%s'
             INTO TABLE %s
             FIELDS TERMINATED BY '%s'
             LINES TERMINATED BY '\n'
             IGNORE 1 LINES",
            $this->conn->real_escape_string($filePath),
            $this->conn->real_escape_string($tableName),
            $this->conn->real_escape_string($delimiter)
        );

        // Execute the query
        if (mysqli_query($this->conn, $sql) === TRUE) {
            echo "Data loaded successfully from file $filePath into table $tableName.";
        } else {
            echo "Error loading data: " . mysqli_error($this->conn);
        }
    }

    function __destruct()
    {
        // Close the connection when the object is destroyed
        if ($this->conn) {
            mysqli_close($this->conn);
        }
    }
}
