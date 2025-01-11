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
            $this->validateCreateTestRequest($requestData);

            $this->testService->createTest(
                $requestData['title'],
                $requestData['description'] ?? '',
                $requestData['created_by'],
                $requestData['questions']
            );

            header('Location: /tests');
            exit; 
        } catch (InvalidArgumentException $e) {
            $this->handleError($e->getMessage(), '/tests/create');
        } catch (Exception $e) {
            $this->handleError("Ошибка при создании теста: " . $e->getMessage(), '/tests/create');
        }
    }

    public function listTests(): array
    {
        $teacherId = $_SESSION['user']['id'] ?? 0; 
        return $this->testService->getTestsByTeacher($teacherId);
    }

    public function viewTest(int $testId): array
    {
        $this->validatePositiveId($testId, "теста");

        $test = $this->testService->getTestById($testId);
        $questions = $this->testService->getQuestionsByTestId($testId);

        return [
            'test' => $test,
            'questions' => $questions,
        ];
    }

    public function getAnswerByStudent(int $studentId): array 
    {
        $this->validatePositiveId($studentId, "студента");
        return $this->testService->getAnswerByStudent($studentId);
    }

    public function getAvailableTestsForStudent(int $studentId): array
    {
        $this->validatePositiveId($studentId, "студента");
        return $this->testService->getAvailableTestsForStudent($studentId);
    }

    public function sendTestResult(int $testId, int $studentId, float $score): void
    {
        $this->validatePositiveId($testId, "теста");
        $this->validatePositiveId($studentId, "студента");

        $this->testService->sendTestResult($testId, $studentId, $score);
    }

    private function validateCreateTestRequest(array $requestData): void
    {
        if (empty($requestData['title']) || empty($requestData['questions'])) {
            throw new InvalidArgumentException("Заголовок теста и вопросы обязательны.");
        }
    }

    private function validatePositiveId(int $id, string $entityName): void
    {
        if ($id <= 0) {
            throw new InvalidArgumentException("Некорректный идентификатор $entityName.");
        }
    }

    private function handleError(string $message, string $redirectUrl): void
    {
        echo "Ошибка: " . $message;
        header("Location: $redirectUrl");
        exit; 
    }
}
