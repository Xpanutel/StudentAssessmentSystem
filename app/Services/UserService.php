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

    public function getCurrentUser(): ?array
    {
        return $this->userRepository->getUserByUsername($_SESSION['username']);
    }
}
