<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="/app/Src/register.css">
    <title>Регистрация</title>
</head>

<body>
    <div class="container" id="container">
        
        <div class="form-container sign-up">
            <form action="/register" method="POST">
                <h2 class="reg">Зарегистрироваться</h2>
                <input type="text" placeholder="Имя" name="username" required>
                <input type="email" placeholder="Email" name="email" required>
                <input type="password" placeholder="Пароль" name="password" required>
                <div class="form-group">
                    <select class="form-control" id="role" name="role" required>
                        <option value="teacher">Преподаватель</option>
                        <option value="student">Ученик</option>
                    </select>
                </div>
                <button>Зарегистрироваться</button>
            </form>
        </div>

        <div class="form-container sign-in">
            <form action="/login" method="POST">
                <h1 id="text"></h1>
                <input type="email" placeholder="Email" name="email" required>
                <input type="password" placeholder="Пароль" name="password" required>
                <button class="btn btn-success mb-2 w-100"">Войти</button>
            </form>
        </div>

        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-left">
                    <h1>Добро Пожаловать!</h1>
                    <p>Введите свои личные данные, чтобы использовать все возможности сайта</p>
                    <button class="hidden" id="login">Есть аккаунт?</button>
                </div>
                <div class="toggle-panel toggle-right">
                    <h1>Привет, Друг!</h1>
                    <p>Зарегистрируйтесь, указав свои личные данные, чтобы использовать все функции сайта.</p>
                    <button class="hidden" id="register">Зарегистрироваться</button>
                </div>
            </div>
        </div>
    </div>

    <script src="/app/Src/register.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
        
    </script>
    
</body>
</html>