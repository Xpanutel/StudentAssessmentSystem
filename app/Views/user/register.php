<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Регистрация</title>
</head>
<body>
    <h1>Регистрация</h1>
    <form action="/register" method="POST">
        <label for="username">Имя пользователя:</label>
        <input type="text" name="username" required>
        <br>
        <label for="password">Пароль:</label>
        <input type="password" name="password" required>
        <br>
        <label for="role">Роль:</label>
        <input type="text" name="role" required>
        <br>
        <label for="email">Email:</label>
        <input type="email" name="email" required>
        <br>
        <button type="submit">Зарегистрироваться</button>
    </form>
</body>
</html>
