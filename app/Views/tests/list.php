<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Список тестов</title>
</head>
<body>
    <h1>Список тестов</h1>
    <ul>
        <?php foreach ($tests as $test): ?>
            <li>
                <a href="/tests/<?= $test['id'] ?>"><?= htmlspecialchars($test['title']) ?></a>
            </li>
        <?php endforeach; ?>
    </ul>
    <a href="/test/create">Добавить тест</a>
</body>
</html>