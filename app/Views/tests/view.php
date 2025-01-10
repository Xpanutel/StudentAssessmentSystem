<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($data['test']['title']) ?></title>
</head>
<body>
    <h1><?= htmlspecialchars($data['test']['title']) ?></h1>
    <p><?= htmlspecialchars($data['test']['description']) ?></p>

    <h2>Вопросы</h2>
    <form action="/tests/submit" method="POST">
    <input type="hidden" name="test_id" value="<?= $data['test']['id'] ?>"> 
    <?php foreach ($data['questions'] as $index => $question): ?>
        <div>
            <p><?= htmlspecialchars($question['question_text']) ?></p>
            <input type="hidden" name="questions[<?= $index ?>][id]" value="<?= $question['id'] ?>">
            <input type="hidden" name="questions[<?= $index ?>][correct_answer]" value="<?= $question['correct_answer'] ?>">
            <input type="text" name="questions[<?= $index ?>][user_answer]" placeholder="Ваш ответ" required>
        </div> 
    <?php endforeach; ?>
    <button type="submit">Отправить ответы</button>
</form>
</body>
</html>

