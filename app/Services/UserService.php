<?php

class UserService
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function registerUser(string $username, string $password, string $role, string $email): void
    {
        if ($this->userRepository->getUserByUsername($username)) {
            throw new Exception('Пользователь с таким именем уже существует.');
        }
        $this->userRepository->createUser($username, $password, $role, $email);
    }

    public function authenticate(string $email, string $password): array {
        $user = $this->userRepository->getUserByEmail($email);
    
        if (!$user) {
            throw new Exception("Пользователь не найден. Email: $email");
        }

        if (!password_verify($password, $user['password'])) {
            throw new Exception("Неверный пароль");
        }
    
        return $user; 
    }
    
    public function getCurrentUser(): ?array { return $this->userRepository->getUserByUsername($_SESSION['user']['username']); }
}
