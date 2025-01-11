<?php
// Функция для безопасного вывода данных
function escapeHtml($data) {
    return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
}

// Функция для вычисления оценки
function calculateGrade($correctCount, $totalCount) {
    if ($totalCount === 0) return 0; // Защита от деления на ноль
    $percentage = ($correctCount / $totalCount) * 100;

    if ($percentage >= 81) return 5;
    if ($percentage >= 61) return 4;
    if ($percentage >= 41) return 3;
    if ($percentage >= 21) return 2;
    return 1;
}

// Подсчет правильных ответов
$correctAnswersCount = 0;
$totalQuestions = count($data['questions']);
$userAnswers = $_POST['questions'] ?? [];

foreach ($data['questions'] as $index => $question) {
    $userAnswer = trim(strtolower($userAnswers[$index]['user_answer'] ?? ''));
    $correctAnswer = trim(strtolower($question['correct_answer']));
    if ($userAnswer === $correctAnswer) {
        $correctAnswersCount++;
    }
}

$grade = calculateGrade($correctAnswersCount, $totalQuestions);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Результаты теста: <?= escapeHtml($data['test']['title']) ?></title>
    <style>
        .correct { color: green; }
        .incorrect { color: red; }
    </style>
</head>
<body>
    <h1>Результаты теста: <?= escapeHtml($data['test']['title']) ?></h1>
    <p><?= escapeHtml($data['test']['description']) ?></p>

    <h2>Ваши ответы</h2>
    <ul>
        <?php foreach ($data['questions'] as $index => $question): ?>
            <?php 
            $userAnswer = escapeHtml($userAnswers[$index]['user_answer'] ?? '');
            $correctAnswer = escapeHtml($question['correct_answer']);
            $isCorrect = strtolower(trim($userAnswer)) === strtolower(trim($correctAnswer));
            ?>
            <li>
                <p><?= escapeHtml($question['question_text']) ?></p>
                <p>Ваш ответ: <?= $userAnswer ?></p>
                <p>Правильный ответ: <?= $correctAnswer ?></p>
                <p class="<?= $isCorrect ? 'correct' : 'incorrect' ?>">
                    <?= $isCorrect ? 'Правильно' : 'Неправильно' ?>
                </p>
            </li>
        <?php endforeach; ?>
    </ul>

    <h2>Итог</h2>
    <p>Вы ответили правильно на <?= $correctAnswersCount ?> из <?= $totalQuestions ?> вопросов.</p>
    <p>Процент правильных ответов: <?= round(($correctAnswersCount / $totalQuestions) * 100, 2) ?>%</p>
    <p>Ваша оценка: <?= $grade ?></p>

    <a href="/tests">Вернуться к списку тестов</a>
</body>
</html>
