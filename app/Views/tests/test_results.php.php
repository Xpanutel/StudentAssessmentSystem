<?php
// Функция для безопасного вывода данных
function escapeHtml($data) {
    return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
}

// Функция для вычисления оценки
function calculateGrade($correctCount, $totalCount) {
    if ($totalCount === 0) return 0; 
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
$testController->sendTestResult($data['test']['id'], $_SESSION['user']['id'], $grade);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Результаты теста</title>
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
        h1, h2 {
            color: #343a40; 
        }
        .correct {
            color: green;
        }
        .incorrect {
            color: red; 
        }
        a {
            display: inline-block;
            margin-top: 20px;
            font-weight: bold;
            color: #007bff; 
        }
        a:hover {
            text-decoration: underline; 
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Результаты теста: <?= escapeHtml($data['test']['title']) ?></h1>
        <p><?= escapeHtml($data['test']['description']) ?></p>

        <h2>Ваши ответы</h2>
        <ul class="list-group">
            <?php foreach ($data['questions'] as $index => $question): ?>
                <?php 
                $userAnswer = escapeHtml($userAnswers[$index]['user_answer'] ?? '');
                $correctAnswer = escapeHtml($question['correct_answer']);
                $isCorrect = strtolower(trim($userAnswer)) === strtolower(trim($correctAnswer));
                ?>
                <li class="list-group-item">
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
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
