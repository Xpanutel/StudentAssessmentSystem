<?php

class DatabaseConnection 
{
    private $host;
    private $username;
    private $password;
    private $dbname;
    private $connection;

    public function __construct(string $host, string $username, string $password, string $dbname) 
    {
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
        $this->dbname = $dbname;
    }

    public function connect(): ?PDO 
    {
        try {
            $this->connection = new PDO("mysql:host={$this->host};dbname={$this->dbname}", $this->username, $this->password);
            // Устанавливаем режим обработки ошибок
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->connection;
        } catch (PDOException $e) {
            // Логируем ошибку и возвращаем null
            error_log("Database connection failed: " . $e->getMessage());
            return null;
        }
    }

    public function getConnection(): ?PDO 
    {
        return $this->connection;
    }
}
