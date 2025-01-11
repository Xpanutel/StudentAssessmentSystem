<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Список тестов</title>
    <style>
        body {
            background-color: #f8f9fa; 
        }
        .container {
            margin-top: 50px;
            padding: 20px;
            background-color: #fff; 
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center; 
            color: #343a40; 
        }
        a {
            text-decoration: none; 
            color: #007bff; 
        }
        a:hover {
            text-decoration: underline; 
        }
    </style>
</head>
<body>
    
<button type="button" class="btn btn-secondary" onclick="window.location.href='/profile'">В ЛИЧНЫЙ КАБИНЕТ</button>

    <div class="container">
        <h1>Список тестов</h1>
        <ul class="list-group">
            <?php foreach ($tests as $test): ?>
                <li class="list-group-item">
                    <a href="/tests/<?= $test['id'] ?>"><?= htmlspecialchars($test['title']) ?></a>
                </li>
            <?php endforeach; ?>
        </ul>
        <div class="text-center mt-4">
            <a href="/tests/create" class="btn btn-primary">Добавить тест</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
