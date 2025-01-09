<?php

class AuthMiddleware
{
    // Метод для проверки авторизации пользователя
    public static function isAuth(array $user): bool
    {
        return !empty($user); 
    }

    public static function showContent(array $user, string $content, string $unauthorizedMessage = "Вы не авторизованы!"): void
    {
        if (self::isAuth($user)) {
            echo $content; 
        } else {
            echo $unauthorizedMessage; 
        }
    }
}
