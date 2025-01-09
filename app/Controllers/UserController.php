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
            $_SESSION['user'] = $requestData;
        } catch (Exception $e) {
            throw $e; 
        }
    }

    public function login(array $requestData): void {
        $email = $requestData['email'];
        $password = $requestData['password'];

        $user = $this->userService->authenticate($email, $password);

        $_SESSION['user'] = $user;
    }

    public function logout()
    {
        $_SESSION = [];
        session_destroy();
        header("Location: /auth");
        exit;
    }

    public function getCurrentUser(): ?array
    {
        return $this->userService->getCurrentUser();
    }

}