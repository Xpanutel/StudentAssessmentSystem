<?php

class TestController
{
    private TestService $testService;

    public function __construct(TestService $testService)
    {
        $this->testService = $testService;
    }

    public function createTest(array $requestData): void
    {
        try {
            if (empty($requestData['title']) || empty($requestData['questions'])) {
                throw new Exception("Заголовок теста и вопросы обязательны.");
            }
            $this->testService->createTest($requestData['title'], $requestData['description'], $requestData['created_by'], $requestData['questions']);
            header('Location: /tests'); 
        } catch (Exception $e) {
            echo "Ошибка: " . $e->getMessage();
            header('Location: /tests/create'); 
        }
    }

    public function listTests(): array
    {
        $teacherId = $_SESSION['user']['id'];
        return $this->testService->getTestsByTeacher($teacherId);
    }

    public function viewTest($testId): array
    {
        if ($testId <= 0) {
            throw new Exception("Некорректный идентификатор теста.");
        }
        $test = $this->testService->getTestById($testId);
        $questions = $this->testService->getQuestionsByTestId($testId);
        
        return [
            'test' => $test,
            'questions' => $questions,
        ];
    }

    public function getAnswerByStudent(int $studentID): array 
    {
        if ($studentID <= 0) {
            throw new Exception("Некорректный идентификатор студента.");
        }
        return $this->testService->getAnswerByStudent($studentID);
    }

    public function getAvailableTestsForStudent(int $studentID): array
    {
        if ($studentID <= 0) {
            throw new Exception("Некорректный идентификатор студента.");
        }
        return $this->testService->getAvailableTestsForStudent($studentID);
    }
}
