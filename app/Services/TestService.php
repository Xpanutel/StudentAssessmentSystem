<?php

class TestService
{
    private Test $testModel;

    public function __construct(Test $testModel)
    {
        $this->testModel = $testModel;
    }

    public function createTest(string $title, string $description, int $createdBy, array $questions): void
    {
        $this->validateCreateTestInputs($title, $questions);

        $this->testModel->createTest($title, $description, $createdBy, $questions);
    }

    public function getTestsByTeacher(int $teacherId): array
    {
        $this->validatePositiveId($teacherId, "учителя");
        return $this->testModel->getTestsByTeacher($teacherId);
    }

    public function getTestById(int $testId): array
    {
        $this->validatePositiveId($testId, "теста");
        return $this->testModel->getTestById($testId);
    }

    public function getQuestionsByTestId(int $testId): array
    {
        $this->validatePositiveId($testId, "теста");
        return $this->testModel->getQuestionsByTestId($testId);
    }

    public function getAnswerByStudent(int $studentId): array
    {
        $this->validatePositiveId($studentId, "студента");
        return $this->testModel->getAnswerByStudent($studentId);
    }

    public function getAvailableTestsForStudent(int $studentId): array 
    {
        $this->validatePositiveId($studentId, "студента");
        return $this->testModel->getAvailableTestsForStudent($studentId);
    }

    public function sendTestResult(int $testId, int $studentId, float $score): void
    {
        $this->validatePositiveId($testId, "теста");
        $this->validatePositiveId($studentId, "студента");
        
        $this->testModel->sendTestResult($testId, $studentId, $score);
    }

    public function getResultTestById(int $testId): array 
    {
        $this->validatePositiveId($testId, "теста");
        return $this->testModel->getResultTestById($testId);
    }

    private function validateCreateTestInputs(string $title, array $questions): void
    {
        if (empty($title) || empty($questions)) {
            throw new InvalidArgumentException("Заголовок теста и вопросы обязательны.");
        }

        foreach ($questions as $question) {
            if (empty($question['text']) || !isset($question['correct'])) {
                throw new InvalidArgumentException("Каждый вопрос должен иметь текст и правильный ответ.");
            }
        }
    }

    private function validatePositiveId(int $id, string $entityName): void
    {
        if ($id <= 0) {
            throw new InvalidArgumentException("Некорректный идентификатор $entityName.");
        }
    }
}