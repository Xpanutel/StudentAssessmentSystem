<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Личный кабинет</title>
</head>
<body>
    <h1>Личный кабинет</h1>
    <?php if ($user): ?>
        <p>Имя пользователя: <?= htmlspecialchars($user['username']) ?></p>
        <p>Роль: <?= htmlspecialchars($user['role']) ?></p>
        <p>Email: <?= htmlspecialchars($user['email']) ?></p>
    <?php else: ?>
        <p>Пользователь не найден.</p>
    <?php endif; ?>
</body>
</html>
