<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Создание теста</title>
</head>

<body>
    <h1>Создание теста</h1>
    <form action="/addtest" method="POST">
        <label for="title">Название теста:</label><br>
        <input type="text" id="title" name="title" required><br><br>
        
        <label for="description">Описание теста:</label><br>
        <textarea id="description" name="description" required></textarea><br><br>
                
        <input type="submit" value="Создать тест">
    </form>
</body>
</html>
