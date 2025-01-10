<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Результаты теста: <?= htmlspecialchars($data['test']['title']) ?></title>
</head>
<body>
    <h1>Результаты теста: <?= htmlspecialchars($data['test']['title']) ?></h1>
    <p><?= htmlspecialchars($data['test']['description']) ?></p>

    <h2>Ваши ответы</h2>
    <ul>
        <?php 
        $correctAnswersCount = 0; // Счетчик правильных ответов
        foreach ($data['questions'] as $index => $question): 
            $userAnswer = $_POST['questions'][$index]['user_answer'] ?? '';
            $correctAnswer = $question['correct_answer'];
            $isCorrect = strtolower(trim($userAnswer)) === strtolower(trim($correctAnswer));
            if ($isCorrect) {
                $correctAnswersCount++;
            }
        ?>
            <li>
                <p><?= htmlspecialchars($question['question_text']) ?></p>
                <p>Ваш ответ: <?= htmlspecialchars($userAnswer) ?></p>
                <p>Правильный ответ: <?= htmlspecialchars($correctAnswer) ?></p>
                <p style="color: <?= $isCorrect ? 'green' : 'red' ?>;">
                    <?= $isCorrect ? 'Правильно' : 'Неправильно' ?>
                </p>
            </li>
        <?php endforeach; ?>
    </ul>

    <h2>Итог</h2>
    <p>Вы ответили правильно на <?= $correctAnswersCount ?> из <?= count($data['questions']) ?> вопросов.</p>
    <p>Процент правильных ответов: <?= round(($correctAnswersCount / count($data['questions'])) * 100, 2) ?>%</p>

    <a href="/tests">Вернуться к списку тестов</a>
</body>
</html>
