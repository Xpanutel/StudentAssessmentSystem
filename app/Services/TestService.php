<?php

class TestService 
{
    private TestRepository $testRepository;

    public function __construct(TestRepository $testRepository) 
    {
        $this->testRepository = $testRepository;
    }

    public function addTest(string $title, string $description, int $created_by): void 
    {
        $this->testRepository->createTest($title, $description, $created_by);
    }

    public function getTests(string $username): array 
    {
        return $this->testRepository->getTestsByTeacher($username);
    }

    public function getTestResults(int $testId): ?array 
    {
        return $this->testRepository->getResultsByTest($testId);
    }
}