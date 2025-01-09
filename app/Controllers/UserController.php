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
            $_SESSION['requestData'] = $requestData;
        } catch (Exception $e) {
            throw $e; 
        }
    }

    public function login(array $requestData): void
    {
        try {
            if (empty($requestData['email']) || empty($requestData['password'])) {
                throw new Exception('Необходимо заполнить все поля');
            }
            $user = $this->userService->loginUser($requestData['email'], $requestData['password']);
            $_SESSION['loginUser'] = [
                'id' => $user['id'],
                'email' => $user['email'],
                'username' => $user['username'],
                'role' => $user['role'],
            ];
        } catch (Exception $e) {
            echo "Ошибка: " . htmlspecialchars($e->getMessage()); 
            include '/app/Views/user/register.php'; 
        }
    }

    public function getCurrentUser(): ?array
    {
        return $this->userService->getCurrentUser();
    }
}