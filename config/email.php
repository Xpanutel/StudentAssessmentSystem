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
        'username' => 'заменить_на_свое',
        
        // Пароль для аутентификации на сервере
        'password' => 'заменить_на_свое',
        
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
