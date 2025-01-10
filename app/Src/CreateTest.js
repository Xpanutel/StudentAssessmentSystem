let questionCount = 1;

// Функция для добавления нового вопроса
function addQuestion() {
    const optionsContainer = document.getElementById('options-container'); 
    const newQuestionDiv = document.createElement('div');
    
    // Устанавливаем классы для нового элемента
    newQuestionDiv.className = 'input-group mb-2';
    
    // Создаем HTML-код для нового вопроса
    newQuestionDiv.innerHTML = `
        
        <input type="text" class="form-control" placeholder="Введите вопрос" 
        id="question_text_${questionCount}" name="questions[${questionCount}][text]" required>
        
        <input type="text" class="form-control ms-2" placeholder="Введите вариант ответа"
        id="correct_answer_${questionCount}" name="questions[${questionCount}][correct]" required>
        
        <button type="button" onclick="removeQuestion(this)" class="btn btn-danger">Удалить</button>
    `;
    
    // Добавляем новый вопрос в контейнер
    optionsContainer.appendChild(newQuestionDiv);
    questionCount++; // Увеличиваем счетчик вопросов
}

// Функция для удаления вопроса
function removeQuestion(button) {
    const questionDiv = button.parentElement; 
    questionDiv.remove(); 
}
