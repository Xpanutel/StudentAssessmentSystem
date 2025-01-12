<?php
session_start();

require 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Подключение основных конфигов
require_once __DIR__ . '/config/database.php'; 
require_once __DIR__ . '/config/DatabaseConnection.php';
require_once __DIR__ . '/config/email.php';
// Подключение роутера
require_once __DIR__ . '/routes/web.php';
// Подключение скриптов по клиенту
require_once __DIR__ . '/app/Models/User.php';
require_once __DIR__ . '/app/Services/UserService.php';
require_once __DIR__ . '/app/Controllers/UserController.php';
// Подключение скриптов для тестов
require_once __DIR__ . '/app/Models/Test.php';
require_once __DIR__ . '/app/Services/TestService.php';
require_once __DIR__ . '/app/Controllers/TestController.php';
// подключение контроллера для работы с email
require_once __DIR__ . '/app/Controllers/EmailController.php';
// Подключение миддливаре
require_once __DIR__ . '/app/Middleware/RoleMiddleware.php';
require_once __DIR__ . '/app/Middleware/AuthMiddleware.php';


// Иницииализация бд
$db = new DatabaseConnection($host, $username, $password, $dbname);
$connection = $db->connect();

// Инициализация роутера
$router = new Router();

// Инициализация репозитория, сервиса, контроллера, модели для пользователей
$userModel = new User($connection);
$userService = new UserService($userModel);
$userController = new UserController($userService);

// Инициализация репозитория, сервиса, контроллера, модели для тестов
$testModel = new Test($connection);
$testService = new TestService($testModel);
$testController = new TestController($testService);

// Инициализация контроллера для работы с почтой 
$emailController = new EmailController($emailConfig);

// Инициализция миддлеваре
$roleMiddleware = new RoleMiddleware();
$authMiddleware = new AuthMiddleware();

// Тут пишем маршуруты
$router->get('/auth', function() {
    include 'app/Views/user/auth.php';
});

$router->post('/register', function() use ($userController){
    $requestData = $_POST;
    try {
        $userController->register($requestData);
        echo "<p>Пользователь успешно зарегистрирован!</p>";
        header("Location: /profile");
    } catch (Exception $e) {
        echo "Ошибка: " . $e->getMessage();
        include 'app/Views/user/auth.php';
    }
});

$router->post('/login', function() use ($userController){
    $requestData = $_POST;
    try {
        $userController->login($requestData);
        header("Location: /profile");
        exit();
    } catch (Exception $e) {
        echo "Ошибка: " . $e->getMessage();
        header('Location: /auth');
        exit();
    }
});

$router->get('/profile', function() use ($userController, $roleMiddleware, $authMiddleware, $testController){
    $authMiddleware->checkAuth();
    $user = $userController->getCurrentUser();
    include 'app/Views/user/profile.php';
});

$router->get('/logout', function() use ($userController) {
    $user = $userController->logout(); 
});

$router->get('/tests', function() use ($testController) {
    $tests = $testController->listTests();
    include 'app/Views/tests/list.php'; 
});

$router->get('/tests/create', function() {
    include 'app/Views/tests/create.php'; 
});

$router->post('/tests/create', function() use ($testController) {
    $requestData = $_POST;
    $testController->createTest($requestData);
});

$router->get('/tests/{id}', function($id) use ($testController) {
    $data = $testController->viewTest($id);
    include 'app/Views/tests/view.php'; 
});

$router->post('/tests/submit', function() use ($testController, $emailController) {
    $testId = $_POST['test_id'];
    $data = $testController->viewTest($testId); 
    include 'app/Views/tests/test_results.php'; 
});

$router->get('/tests/result/{id}', function($id) use ($testController) {
    $data = $testController->getResultTestById($id); 
    include 'app/Views/tests/all_students_results.php'; 
});


// Резолвим запрос
$router->resolve();