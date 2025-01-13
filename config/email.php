<?php

require 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Возвращает массив настроек для SMTP-сервера и отправителя писем
return $emailConfig = [
    // Настройки SMTP-сервера
    'smtp' => [
        // Адрес SMTP-сервера
        'host' => 'app.debugmail.io',
        
        // Имя пользователя для аутентификации на сервере
        "username" => "893c1421-cee4-4651-86f5-7aa0034330e1",
        
        // Пароль для аутентификации на сервере
        "password" => "a3c236d2-8d6a-4259-9655-5cedb3aa10ef",
        
        // Порт подключения к SMTP-серверу
        'port' => 25,
        
        // Тип шифрования соединения
        'secure' => PHPMailer::ENCRYPTION_STARTTLS,
    ],
    
    // Настройки отправителя письма
    'from' => [
        // Электронная почта отправителя
        'email' => 'john.doe@example.org',
        
        // Имя отправителя
        'name' => 'John Doe',
    ],
];
