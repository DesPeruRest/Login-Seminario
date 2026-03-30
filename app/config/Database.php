<?php

class Database
{
    private $host = "localhost";
    private $db_name = "mvc_seminario";
    private $username = "root";
    private $password = "123456";
    private $conn;

    public function connect()
    {
        $this->conn = null;

        try {
            // DSN con charset compatible
            $dsn = "mysql:host={$this->host};dbname={$this->db_name};charset=utf8mb4";

            $this->conn = new PDO($dsn, $this->username, $this->password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false
            ]);

        } catch (PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }

        return $this->conn;
    }
}