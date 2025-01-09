<?php

class UserRepository
{
    private User $userModel;

    public function __construct(User $userModel)
    {
        $this->userModel = $userModel;
    }

    public function createUser(string $username, string $password, string $role, string $email): void
    {
        $this->userModel->create($username, $password, $role, $email);
    }

    public function getUserById(int $id): ?array
    {
        return $this->userModel->findById($id);
    }

    public function getUserByUsername(string $username): ?array
    {
        return $this->userModel->findByUsername($username);
    }

    public function getUserByEmail(string $email): ?array
    {
        return $this->userModel->findByEmail($email);
    }

    public function updateUser(int $id, string $username, string $role, string $email): void
    {
        $this->userModel->update($id, $username, $role, $email);
    }

    public function deleteUser(int $id): void
    {
        $this->userModel->delete($id);
    }
}
