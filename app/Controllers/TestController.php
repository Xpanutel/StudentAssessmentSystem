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
            $this->testService->createTest($requestData['title'], $requestData['description'], $requestData['created_by'], $requestData['questions']);
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
        $test = $this->testService->getTestById($testId);
        $questions = $this->testService->getQuestionsByTestId($testId);
        
        return [
            'test' => $test,
            'questions' => $questions,
        ];
    }

    public function getAnswerByStudent(int $studentID): array 
    {
        return $this->testService->getAnswerByStudent($studentID);
    }
}
