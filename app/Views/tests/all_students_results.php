<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Результаты теста</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<button type="button" class="btn btn-secondary" onclick="window.location.href='/tests'">НАЗАД</button>
    <div class="container mt-5">
        <h2 class="mb-4">Результаты теста</h2>
        
        <?php if (!empty($data)): ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Название теста</th>
                        <th>Имя студента</th>
                        <th>Дата прохождения</th>
                        <th>Оценка</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data as $result): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($result['test_title']); ?></td>
                            <td><?php echo htmlspecialchars($result['student_name']); ?></td>
                            <td><?php echo htmlspecialchars($result['date_taken']); ?></td>
                            <td><?php echo htmlspecialchars($result['score']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Нет данных для отображения.</p>
        <?php endif; ?>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
