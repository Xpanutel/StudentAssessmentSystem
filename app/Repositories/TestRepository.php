<?php

class TestRepository 
{
    private Test $testModel;

    public function __construct(Test $testModel) {
        $this->testModel = $testModel;
    }

    public function createTest(string $title, string $description, int $created_by): void 
    {
        $this->testModel->createTest($title, $description, $created_by);
    }

    public function getTestsByTeacher(string $username): array 
    {
        return $this->testModel->getTestsByTeacher($username);
    }

    public function getResultsByTest(int $testId): ?array 
    {
        return $this->testModel->getResultsByTest($testId);
    }
}