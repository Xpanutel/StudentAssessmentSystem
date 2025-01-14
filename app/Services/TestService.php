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

    public function getAnswerByStudent(int $studentId): array
    {
        return $this->testModel->getAnswerByStudent($studentId);
    }

    public function getAvailableTestsForStudent(int $studentId): array 
    {
        return $this->testModel->getAvailableTestsForStudent($studentId);
    }

    public function sendTestResult(int $testId, int $studentId, float $score): void
    {        
        $this->testModel->sendTestResult($testId, $studentId, $score);
    }

    public function getResultTestById(int $testId): array 
    {
        return $this->testModel->getResultTestById($testId);
    }

    public function saveFile(int $student_id, int $testId, string $filePath, int $filesize): bool 
    {
       return $this->testModel->saveFile($student_id, $testId, $filePath, $filesize);
    }

    public function getPracticalWork(int $studentId, int $testId): array
    {
        return $this->testModel->getPracticalWorkByStudentId($studentId, $testId);
    }
}