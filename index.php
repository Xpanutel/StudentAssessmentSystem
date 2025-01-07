<?php
session_start();

// Подключение основных конфигов
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/config/database.php';

// Подключение скриптов по клиенту
require_once __DIR__ . '/app/Models/User.php';
require_once __DIR__ . '/app/Services/UserService.php';
require_once __DIR__ . '/app/Repositories/UserRepository.php';
require_once 'app/Controllers/UserController.php';

// Подключение к бд
$db = new DatabaseConnection($host, $username, $password, $dbname);
$connection = $db->connect();

if ($connection) {
    echo "Connection successful!";
} else {
    echo "Connection failed!";
}

// Инициализация репозитория, сервиса, контроллера, модели для пользователей
$userModel = new User($connection);
$userRepository = new UserRepository($userModel);
$userService = new UserService($userRepository);
$userController = new UserController($userService);

// обработка действий
$action = $_GET['action'] ?? 'register_form';

switch ($action) {
    case 'register_form':
        // Отображение формы регистрации
        include 'app/Views/user/register.php';
        break;

    case 'register':
        // Обработка регистрации
        $requestData = $_POST;
        try {
            $userController->register($requestData);
            echo "<p>Пользователь успешно зарегистрирован!</p>";
            // Перенаправление на форму регистрации
            header("Location: index.php?action=current_user");
            exit;
        } catch (Exception $e) {
            echo "Ошибка: " . $e->getMessage();
            include 'app/Views/user/register.php';
        }
        break;

    case 'current_user':
        // Отображение текущего пользователя
        $user = $userController->getCurrentUser (); // Получаем текущего пользователя
        include 'app/Views/user/current_user.php';
        break;

    default:
        // Если действие не распознано, перенаправляем на форму регистрации
        header("Location: index.php?action=register_form");
        exit;
}