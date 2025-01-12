<?php

// Конфигурация базы данных
$host = "localhost"; // тут меняешь на своё
$username = "root"; // тут меняешь на своё
$password = ""; // тут меняешь на своё
$dbname = "StudentAssessmentSystem"; // тут меняешь на своё

class DBCON 
{
    private $host;
    private $username;
    private $password;
    private $dbname;
    private $connection;

    public function __construct(string $host, string $username, string $password, string $dbname) 
    {
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
        $this->dbname = $dbname;
    }

    public function connect(): ?PDO 
    {
        try {
            $this->connection = new PDO("mysql:host={$this->host};dbname={$this->dbname};charset=utf8", $this->username, $this->password);
            // Устанавливаем режим обработки ошибок
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->connection;
        } catch (PDOException $e) {
            // Логируем ошибку и возвращаем null
            error_log("Database connection failed: " . $e->getMessage());
            return null;
        }
    }

    public function getConnection(): ?PDO 
    {
        return $this->connection;
    }
}

function getFile($student_id, $db) {
    // Запрос для получения информации о файле из базы данных
    $stmt = $db->prepare("SELECT * FROM practical_work WHERE student_id = ?");
    $stmt->execute([$student_id]);
    
    return $stmt->fetch(PDO::FETCH_ASSOC); // Возвращаем всю запись
}

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Просмотр изображения</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 50px;
        }
        .image-container {
            text-align: center;
            margin-top: 20px;
        }
        .image-container img {
            max-width: 100%;
            height: auto;
            border: 1px solid #dee2e6;
            border-radius: 5px;
        }
    </style>
</head>
<body>

<div class="container">
    <h1 class="text-center">Просмотр загруженного изображения</h1>

    <?php
    // Создание подключения к базе данных
    $database = new DBCON($host, $username, $password, $dbname);
    $db = $database->connect();

    if ($db) {
        // Получаем идентификатор студента (например, из сессии или запроса)
        $student_id = 1; // Замените на актуальный идентификатор студента

        // Получаем файл
        $file = getFile($student_id, $db);

        if ($file) {
            $filePath = $file['file_path']; // Получаем путь к файлу из базы данных
            $fullPath = dirname(__DIR__, 3) . '/uploads/' . basename($filePath);

            // Проверка, существует ли файл
            if (file_exists($fullPath)) {
                echo '<div class="image-container">';
                echo '<img src="/uploads/' . htmlspecialchars(basename($filePath)) . '" alt="Загруженное изображение">';
                echo '</div>';
            } else {
                echo '<div class="alert alert-danger" role="alert">Файл не найден в директории uploads.</div>';
            }
        } else {
            echo '<div class="alert alert-danger" role="alert">Файл не найден в базе данных.</div>';
        }
    } else {
        echo '<div class="alert alert-danger" role="alert">Ошибка подключения к базе данных.</div>';
    }
    ?>

</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
