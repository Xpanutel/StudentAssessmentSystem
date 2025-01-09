<?php

class User
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function create(string $username, string $password, string $role, string $email): void
    {
        $stmt = $this->db->prepare("INSERT INTO users (username, password, role, email) VALUES (:username, :password, :role, :email)");
        $stmt->execute([
            ':username' => $username,
            ':password' => password_hash($password, PASSWORD_DEFAULT),
            ':role' => $role,
            ':email' => $email
        ]);
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function findByUsername(string $username): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->execute([':username' => $username]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function findByEmail(string $email): ?array {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
        $stmt->execute(['email' => $email]);
        $userData = $stmt->fetch(PDO::FETCH_ASSOC);

        return $userData ?: null;
    }

    public function update(int $id, string $username, string $role, string $email): void
    {
        $stmt = $this->db->prepare("UPDATE users SET username = :username, role = :role, email = :email, updated_at = CURRENT_TIMESTAMP WHERE id = :id");
        $stmt->execute([
            ':username' => $username,
            ':role' => $role,
            ':email' => $email,
            ':id' => $id
        ]);
    }

    public function delete(int $id): void
    {
        $stmt = $this->db->prepare("DELETE FROM users WHERE id = :id");
        $stmt->execute([':id' => $id]);
    }

    public function getCurrentUser(): ?array
    {
        if (isset($_SESSION['user_id'])) {
            return $this->findById($_SESSION['user_id']);
        }
        return null;
    }
}
