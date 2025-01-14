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
            $this->testService->createTest(
                $requestData['title'],
                $requestData['description'] ?? '',
                $requestData['created_by'],
                $requestData['questions']
            );

            header('Location: /tests');
            exit; 
        } catch (Exception $e) {
            echo "Ошибка: " . $e->getMessage();
        }
    }

    public function listTests(): array
    {
        $teacherId = $_SESSION['user']['id'] ?? 0; 
        return $this->testService->getTestsByTeacher($teacherId);
    }

    public function viewTest(int $testId): array
    {
        $test = $this->testService->getTestById($testId);
        $questions = $this->testService->getQuestionsByTestId($testId);

        return [
            'test' => $test,
            'questions' => $questions,
        ];
    }

    public function getAnswerByStudent(int $studentId): array 
    {
        return $this->testService->getAnswerByStudent($studentId);
    }

    public function getAvailableTestsForStudent(int $studentId): array
    {
        return $this->testService->getAvailableTestsForStudent($studentId);
    }

    public function sendTestResult(int $testId, int $studentId, float $score): void
    {
       $this->testService->sendTestResult($testId, $studentId, $score);
    }

    public function getResultTestById(int $testId): array 
    {
        return $this->testService->getResultTestById($testId);
    }

    public function upload(array $requestData): void 
    {
        try {
            $file = $_FILES['image'];

            if ($file['error'] !== UPLOAD_ERR_OK) {
                throw new RuntimeException('Ошибка загрузки файла.');
            }

            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            if (!in_array($file['type'], $allowedTypes, true)) {
                throw new InvalidArgumentException('Допустимы только изображения.');
            }

            $this->testService->saveFile($_SESSION['user']['id'], $requestData['test_id'], basename($file['name']), $file['size']);

            $_SESSION['file'] = $file;

            $this->saveFile($file);

        } catch (Exception $e) {
            echo "Ошибка: " . $e->getMessage();
        }
    }

    private function saveFile(array $file): void 
    {
        $uploadDir = __DIR__ . '/../../uploads/';
        $fileName = basename($file['name']);
        $filePath = $uploadDir . $fileName;

        if (!is_dir($uploadDir) || !is_writable($uploadDir)) {
            throw new RuntimeException('Директория загрузки недоступна.');
        }

        if (!move_uploaded_file($file['tmp_name'], $filePath)) {
            throw new RuntimeException('Не удалось переместить загруженный файл.');
        }
    }

    public function showPracticalWork(int $studentId, int $testId): array 
    {
        return $this->testService->getPracticalWork($studentId, $testId);
    }
}
