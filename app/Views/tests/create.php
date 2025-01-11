<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Создание теста</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f8f9fa;
    }
    .card {
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
  </style>
  
</head>
<body>

<button type="button" class="btn btn-secondary" onclick="window.location.href='/profile'">В ЛИЧНЫЙ КАБИНЕТ</button>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header bg-dark text-white text-center">
                    <h4>Создание теста</h4>
                </div>

                <div class="card-body">
                    <form action="/tests/create" method="POST">
                        <!-- Название теста -->
                        <div class="mb-3">
                            <label for="testName" class="form-label">Название теста</label>
                            <input type="text" class="form-control"  name="title" id="testName" placeholder="Введите название теста">
                            
                            <label for="description">Описание:</label>
                            <textarea id="description" class="form-control" rows="4" name="description"></textarea>
                        </div>

                        <!-- Добавление вариантов ответа с вопросами -->
                        <div id="options-container" class="mb-3">
                            <div class="question">
                                <label class="form-label">Вопросы</label>
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control" placeholder="Введите вопрос" 
                                        id="question_text_0" name="questions[0][text]" required>

                                    <input type="text" class="form-control ms-2" placeholder="Введите вариант ответа" 
                                        id="correct_answer_0" name="questions[0][correct]" required>
                                    <button class="btn btn-danger" onclick="removeQuestion(this)">Удалить</button>
                                </div>
                            </div>    
                        </div>
  
                        <!-- Кнопки действий -->
                        <div class="d-flex justify-content-between">
                            <button type="button" class="btn btn-primary" onclick="addQuestion()">Добавить вопрос</button>
                        </div>

                        <br>

                        <input type="hidden" name="created_by" value="<?= htmlspecialchars($_SESSION['user']['id']) ?>"> 
                        <button class="btn btn-success mb-3" type="submit">Создать тест</button>
                    </form>    
                </div>
            </div>
        </div>
    </div>
</div>

<script src="/app/Src/createTest.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
