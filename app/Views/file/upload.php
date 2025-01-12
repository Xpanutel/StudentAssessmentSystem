<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Загрузка изображения</title>
</head>
<body>
<div class="container mt-5">
    <h2>Загрузить изображение</h2>

    <?php if (isset($_SESSION['error_message'])): ?>
        <div class="alert alert-danger">
            <?= htmlspecialchars($_SESSION['error_message']) ?>
            <?php unset($_SESSION['error_message']); // Удаляем сообщение после отображения ?>
        </div>
    <?php endif; ?>

    <form action="/upload" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="image">Выберите изображение:</label>
            <input type="file" class="form-control-file" name="image" accept="image/*" required>
        </div>
        <button type="submit" class="btn btn-primary">Загрузить</button>
    </form>
</div>
</body>
</html>
