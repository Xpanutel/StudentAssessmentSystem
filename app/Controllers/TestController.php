<?php

class TestController 
{
    private TestService $testService;

    public function __construct(TestService $testService) 
    {
        $this->testService = $testService;
    }

    public function createTest(array $requestData, array $user): void 
    {
        try {
            if ($this->testService->addTest($requestData['title'], $requestData['description'], $user['id'])) {
                echo "Тест успешно добавлен.";
            }
        } catch (Exception $e) {
            echo "Ошибка: " . htmlspecialchars($e->getMessage());
        }
    }

    public function listTests(string $username): array 
    {
        try {
            $tests = $this->testService->getTests($username);
            return $tests;
        } catch (Exception $e) {
            echo "Ошибка: " . htmlspecialchars($e->getMessage());
            return [];
        }
    }

    public function viewTestResults(int $testId): void 
    {
        try {
            $results = $this->testService->getTestResults($testId);
            while ($row = $results->fetch(PDO::FETCH_ASSOC)) {
                echo "Студент ID: " . htmlspecialchars($row['student_id']) . " - Оценка: " . htmlspecialchars($row['score']) . "<br>";
            }
        } catch (Exception $e) {
            echo "Ошибка: " . htmlspecialchars($e->getMessage());
        }
    }
}