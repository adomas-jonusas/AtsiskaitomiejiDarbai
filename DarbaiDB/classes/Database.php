<?php

class Database
{
    private PDO $connection;

    public function __construct()
    {
        $host = 'localhost';
        $database = 'darbai_db';
        $username = 'root';
        $password = '';

        $this->connection = new PDO(
            "mysql:host=$host;dbname=$database;charset=utf8mb4",
            $username,
            $password,
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );
    }

    public function getConnection(): PDO
    {
        return $this->connection;
    }
}
