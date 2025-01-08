<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Список тестов</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?= $_SESSION['requestData']['username'] ?>
    <div class="container">
        <h1 class="mt-5">Список тестов</h1>
        <table class="table mt-4">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Название</th>
                    <th>Описание</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <?php if (!empty($tests)) { ?>
                <?php foreach ($tests as $test) { ?>
                <tr>
                    <td><?= $test['id']; ?></td>
                    <td><?= $test['title']; ?></td>
                    <td><?= $test['description']; ?></td>
                    <td><a href="take_test.php?id=<?= $test['id'] ?>" class="btn btn-success">Пройти тест</a></td>
                </tr>
                <?php } ?>
            <?php } else { ?>
                <tr>
                    <td colspan="4">Тесты не найдены.</td>
                </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>
