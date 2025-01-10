<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Личный кабинет</title>
    <link rel="stylesheet" href="/css/cabinet.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Личный Кабинет</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/tests">Тесты</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="/profile">Личный кабинет</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/logout">Выход</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="row">
            <!-- Profile Section -->
            <div class="col-md-4">
                <div class="profile-card text-center">
                    <h1 class="text-primary"><?= htmlspecialchars($user['role']) ?></h1>
                    <h3 class="mb-0"><?= htmlspecialchars($user['username']) ?></h3>
                    <p class="text-muted"><?= htmlspecialchars($user['email']) ?></p>
                </div>
            </div>

            <!-- Info Section -->
            <div class="col-md-8">
                <div class="info-section">
                    <h4 class="text-primary">Информация</h4>
                    <table class="table table-striped mt-3">
                        <tbody>
                            <tr>
                                <th scope="row">Дата регистрации</th>
                                <td><?= htmlspecialchars($user['created_at']) ?></td> 
                            </tr>
                            <tr>
                                <th scope="row">Статус</th>
                                <td>Активный</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="info-section mt-4">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Ваше имя: <strong><?= htmlspecialchars($user['username']) ?></strong></li>
                        <li class="list-group-item">Email: <strong><?= htmlspecialchars($user['email']) ?></strong></li>
                    </ul>
                </div>
            </div>
        </div>

        <?php if ($roleMiddleware->isTeacher($user)) { ?>
            <div class="row mt-4">
                <div class="col-md-4 mx-auto">
                    <div class="card text-center">
                        <div class="card-body d-flex flex-column align-items-center"> 
                            <h5 class="card-title">Управление тестами</h5>
                            <button type="button" class="btn btn-success mb-2 w-100" onclick="window.location.href='/tests/create'">Создать</button>
                            <button type="button" class="btn btn-success mb-2 w-100" onclick="window.location.href='/tests'">Посмотреть</button>
                        </div>
                    </div>
                </div>
            </div>
        <?php } else { 
            $ans = $testController->getAnswerByStudent($user['id']);     
        ?> 
            <div class="mt-5">
                <div id="typewriter">
                    <span id="text" style="font-size: 25px;"></span>
                </div>

                <table class="table table-striped mt-3">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Оценка</th>
                            <th scope="col">Дата прохождения</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($ans as $answer) { ?>
                            <tr>
                                <td><?= htmlspecialchars($answer['test_id']) ?></td>
                                <td><?= htmlspecialchars($answer['score']) ?></td>
                                <td><?= htmlspecialchars($answer['created_at']) ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        <?php } ?>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/Test.js"></script>
</body>
</html>
