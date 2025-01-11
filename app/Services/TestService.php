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
            if (empty($question['text']) || !isset($question['correct'])) {
                throw new Exception("Каждый вопрос должен иметь текст и правильный ответ.");
            }
        }

        $this->testModel->createTest($title, $description, $createdBy, $questions);
    }

    public function getTestsByTeacher(int $teacherId): array
    {
        if ($teacherId <= 0) {
            throw new Exception("Некорректный идентификатор учителя.");
        }
        return $this->testModel->getTestsByTeacher($teacherId);
    }

    public function getTestById(int $testId): array
    {
        if ($testId <= 0) {
            throw new Exception("Некорректный идентификатор теста.");
        }
        return $this->testModel->getTestById($testId);
    }

    public function getQuestionsByTestId(int $testId): array
    {
        if ($testId <= 0) {
            throw new Exception("Некорректный идентификатор теста.");
        }
        return $this->testModel->getQuestionsByTestId($testId);
    }

    public function getAnswerByStudent(int $studentID): array
    {
        if ($studentID <= 0) {
            throw new Exception("Некорректный идентификатор студента.");
        }
        return $this->testModel->getAnswerByStudent($studentID);
    }

    public function getAvailableTestsForStudent(int $studentID): array 
    {
        if ($studentID <= 0) {
            throw new Exception("Некорректный идентификатор студента.");
        }
        return $this->testModel->getAvailableTestsForStudent($studentID);
    }
}
