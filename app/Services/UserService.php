<?php

class UserService
{
    private User $userModel;

    public function __construct(User $userModel)
    {
        $this->userModel = $userModel;
    }

    public function registerUser(string $username, string $password, string $role, string $email): void
    {
        if ($this->userModel->findByUsername($username)) {
            throw new Exception('Пользователь с таким именем уже существует.');
        }
        $this->userModel->create($username, $password, $role, $email);
    }

    public function authenticate(string $email, string $password): array {
        $user = $this->userModel->findByEmail($email);
    
        if (!$user) {
            throw new Exception("Пользователь не найден. Email: $email");
        }

        if (!password_verify($password, $user['password'])) {
            throw new Exception("Неверный пароль");
        }
    
        return $user; 
    }
    
    public function getCurrentUser(): ?array { return $this->userModel->findByUsername($_SESSION['user']['username']); }
}
