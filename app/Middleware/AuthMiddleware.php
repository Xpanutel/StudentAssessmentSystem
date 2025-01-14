<?php

class AuthMiddleware
{
    public function checkAuth()
    {
        if (empty($_SESSION['user'])) {
            header("Location: /");
            exit(); 
        }
        return true; 
    }
}

