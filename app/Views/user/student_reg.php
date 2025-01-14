<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Форма регистрации</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/app/Src/RegChildren.css">

</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
            <div class="card">
                <h3 class="card-title">Регистрация</h3>
                <div class="card-body p-4">
                <form method="POST" action="/student/reg">
                    <div class="mb-3">
                    <label for="username" class="form-label">Имя пользователя</label>
                    <input type="text" class="form-control input" id="username" placeholder="Введите имя пользователя" name="username" required>
                    </div>
                    <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control input" id="email" placeholder="Введите email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Пароль</label>
                    <div class="input-group">
                        <input type="password" class="form-control input" id="password" placeholder="Введите пароль" name="password" required>
                        <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                        Показать
                    </button>
                    </div>
                </div>
                <div class="form-group" hidden>
                    <select class="form-control" id="role" name="role" required>
                        <option value="student">Ученик</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary w-100 btt">Зарегистрироваться</button>
                </form>
                </div>
            </div>
            </div>
        </div>
    </div>

  <script src="/app/Src/RegChildren.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
