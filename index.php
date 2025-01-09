<?php
session_start();

// Подключение основных конфигов
require_once __DIR__ . '/config/database.php'; 
require_once __DIR__ . '/config/DatabaseConnection.php';
// Подключение роутера
require_once __DIR__ . '/routes/web.php';
// Подключение скриптов по клиенту
require_once __DIR__ . '/app/Models/User.php';
require_once __DIR__ . '/app/Services/UserService.php';
require_once __DIR__ . '/app/Repositories/UserRepository.php';
require_once __DIR__ . '/app/Controllers/UserController.php';
// Подключение скриптов для тестов
require_once __DIR__ . '/app/Models/Test.php';
require_once __DIR__ . '/app/Services/TestService.php';
require_once __DIR__ . '/app/Repositories/TestRepository.php';
require_once __DIR__ . '/app/Controllers/TestController.php';
// Подключение миддливаре
require_once __DIR__ . '/app/Middleware/RoleMiddleware.php';


// Иницииализация бд
$db = new DatabaseConnection($host, $username, $password, $dbname);
$connection = $db->connect();

// Инициализация роутера
$router = new Router();

// Инициализация репозитория, сервиса, контроллера, модели для пользователей
$userModel = new User($connection);
$userRepository = new UserRepository($userModel);
$userService = new UserService($userRepository);
$userController = new UserController($userService);

// Инициализация репозитория, сервиса, контроллера, модели для тестов
$testModel = new Test($connection);
$testRepository = new TestRepository($testModel);
$testService = new TestService($testRepository);
$testController = new TestController($testService);

$roleMiddleware = new RoleMiddleware();

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

$router->get('/profile', function() use ($userController, $roleMiddleware){
    $user = $userController->getCurrentUser();
    include 'app/Views/user/profile.php';
});

$router->get('/logout', function() use ($userController) {
    $user = $userController->logout(); 
});

$router->get('/addtest', function() {
    include 'app/Views/test/add_test.php';
});

$router->get('/viewstest', function() use ($testController, $userController) {
    $tests = $testController->listTests($_SESSION['requestData']['username']);
    include 'app/Views/test/view_tests.php';
});

$router->post('/addtest', function() use ($testController, $userController) {
    $requestData = $_POST;
    $user = $userController->getCurrentUser(); 
    try {
        $testController->createTest($requestData, $user);
        echo "<p>Пользователь успешно зарегистрирован!</p>";
        header("Location: /profile");
    } catch (Exception $e) {
        echo "Ошибка: " . $e->getMessage();
        include 'app/Views/user/register.php';
    }
});

// Резолвим запрос
$router->resolve();