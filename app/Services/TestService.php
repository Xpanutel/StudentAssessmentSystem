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
        if (empty($title) || empty($questions)) {
            throw new Exception("Заголовок теста и вопросы обязательны.");
        }

        foreach ($questions as $question) {
            if (empty($question['text']) || empty($question['correct'])) {
                throw new Exception("Каждый вопрос должен иметь текст и правильный ответ.");
            }
        }

        $this->testModel->createTest($title, $description, $createdBy, $questions);
    }

    public function getTestsByTeacher(int $teacherId): array
    {
        return $this->testModel->getTestsByTeacher($teacherId);
    }

    public function getTestById(int $testId): array
    {
        return $this->testModel->getTestById($testId);
    }

    public function getQuestionsByTestId(int $testId): array
    {
        return $this->testModel->getQuestionsByTestId($testId);
    }
}
