<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title><?= htmlspecialchars($data['test']['title']) ?></title>
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
    </style>
</head>
<body>
<button type="button" class="btn btn-secondary" onclick="window.location.href='/profile'">В ЛИЧНЫЙ КАБИНЕТ</button>

<div class="container">
    <h1 class="text-center"><?= htmlspecialchars($data['test']['title']) ?></h1>
    <p class="text-center"><?= htmlspecialchars($data['test']['description']) ?></p>

    <h2>Вопросы</h2>
    <form id="combinedForm" action="/tests/submit" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="test_id" value="<?= $data['test']['id'] ?>"> 

        <!-- Вопросы -->
        <div id="questionsSection">
            <?php foreach ($data['questions'] as $index => $question): ?>
                <div class="mb-3">
                    <p><?= htmlspecialchars($question['question_text']) ?></p>
                    <input type="hidden" name="questions[<?= $index ?>][id]" value="<?= $question['id'] ?>">
                    <input type="hidden" name="questions[<?= $index ?>][correct_answer]" value="<?= $question['correct_answer'] ?>">
                    <input type="text" name="questions[<?= $index ?>][user_answer]" class="form-control" placeholder="Ваш ответ" required>
                </div> 
            <?php endforeach; ?>
            <button type="button" class="btn btn-primary" onclick="showUploadSection()">Далее</button>
        </div>

        <!-- Загрузка изображения -->
        <div id="uploadSection" style="display: none; margin-top: 20px;">
            <h2>Загрузить изображение</h2>

            <?php if (isset($_SESSION['error_message'])): ?>
                <div class="alert alert-danger">
                    <?= htmlspecialchars($_SESSION['error_message']) ?>
                    <?php unset($_SESSION['error_message']); // Удаляем сообщение после отображения ?>
                </div>
            <?php endif; ?>

            <div class="form-group">
                <label for="image">Выберите изображение:</label>
                <input type="file" class="form-control-file" name="image" accept="image/*" required>
            </div>
            <button type="submit" class="btn btn-primary">Отправить ответы</button>
        </div>
    </form>
</div>

<script>
function showUploadSection() {
    // Скрываем секцию с вопросами и показываем секцию загрузки изображения
    document.getElementById('questionsSection').style.display = 'none';
    document.getElementById('uploadSection').style.display = 'block';
}
</script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
