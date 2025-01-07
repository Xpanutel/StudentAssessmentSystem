<?php

class UserController
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function register(array $requestData): void
    {
        try {
            $this->userService->registerUser($requestData['username'], $requestData['password'], $requestData['role'], $requestData['email']);
            $_SESSION['username'] = $requestData['username'];
        } catch (Exception $e) {
            throw $e; 
        }
    }

    public function getCurrentUser (): ?array
    {
        return $this->userService->getCurrentUser();
    }
}