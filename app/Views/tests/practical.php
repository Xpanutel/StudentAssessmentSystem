<?php
if (!empty($studentWork) && is_array($studentWork)) {
    $work = $studentWork[0];

    $filePath = isset($work['file_path']) ? '/../../uploads/' . $work['file_path'] : 'default_image.jpg'; 
    $fileSize = isset($work['file_size']) ? $work['file_size'] : 0; 
    $grade = isset($work['score']) ? $work['score'] : 'Не оценено'; 
} else {
    $filePath = 'default_image.jpg';
    $fileSize = "0";
    $grade = 'Не оценено';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Проверка практической работы</title>
    <style>
        .img-container {
            width: 100%; /* Ширина контейнера 100% */
            height: 300px; /* Высота изображения фиксированная */
            overflow: hidden; /* Скрываем часть изображения, выходящую за пределы контейнера */
            display: flex; /* Используем flexbox для центрирования */
            justify-content: center; /* Центрируем по горизонтали */
            align-items: center; /* Центрируем по вертикали */
            background-color: #f8f9fa; /* Светлый фон для контейнера */
        }
        .img-container img {
            max-width: 100%; /* Максимальная ширина 100% */
            max-height: 100%; /* Максимальная высота 100% */
            object-fit: contain; /* Сохраняем пропорции изображения */
        }
    </style>
</head>
<body>
    <div class="container my-5">
        <h1 class="text-center mb-4">Практическая работа студента</h1>
        
        <h2 class="mb-3">Загруженное изображение</h2>
        <div class="img-container mb-4">
            <img src="<?php echo htmlspecialchars($filePath); ?>" alt="Загруженное изображение" class="img-fluid" />
        </div>
        
        <h2 class="mb-3">Оценка</h2>
        <p class="lead"><?php echo htmlspecialchars($grade); ?></p>

        <h2 class="mb-3">Размер файла</h2>
        <p><?php echo htmlspecialchars($fileSize); ?> байт</p>

        <a href="/tests" class="btn btn-secondary">Назад к списку студентов</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
