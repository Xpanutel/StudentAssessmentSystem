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

    public function loginUser(string $email, string $password): ?array
    {
        $user = $this->userRepository->getUserByEmail($email);

        if (!$user) {
            throw new Exception('Пользователь с таким email не найден.');
        }

        if (!password_verify($password, $user['password'])) {
            throw new Exception('Неверный пароль.');
        }

        return [
            'id' => $user['id'],
            'email' => $user['email'],
            'name' => $user['username'],
            'role' => $user['role'],
        ];
    }

    public function getCurrentUser(): ?array
    {
        return $this->userRepository->getUserByUsername($_SESSION['requestData']['username']);
    }
}
