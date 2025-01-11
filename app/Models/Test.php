<?php

class Test
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function createTest(string $title, string $description, int $createdBy, array $questions): void
    {
        try {
            $this->db->beginTransaction();

            $stmt = $this->db->prepare("INSERT INTO tests (title, description, created_by) VALUES (?, ?, ?)");
            $stmt->execute([$title, $description, $createdBy]);
            $testId = $this->db->lastInsertId();

            foreach ($questions as $question) {
                $this->validateQuestion($question); 

                $stmt = $this->db->prepare("INSERT INTO questions (test_id, question_text, correct_answer) VALUES (?, ?, ?)");
                $stmt->execute([$testId, $question['text'], $question['correct']]);
            }

            $this->db->commit();
        } catch (Exception $e) {
            $this->db->rollBack(); 
            error_log("Ошибка при создании теста: " . $e->getMessage());
            throw new Exception("Не удалось создать тест. Пожалуйста, попробуйте еще раз.");
        }
    }

    public function getTestsByTeacher(int $teacherId): array
    {
        $this->validateTeacherId($teacherId); 

        $stmt = $this->db->prepare("SELECT * FROM tests WHERE created_by = ?");
        $stmt->execute([$teacherId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTestById(int $testId): array
    {
        $this->validateTestId($testId); 

        $stmt = $this->db->prepare("SELECT * FROM tests WHERE id = ?");
        $stmt->execute([$testId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getQuestionsByTestId(int $testId): array
    {
        $this->validateTestId($testId); 

        $stmt = $this->db->prepare("SELECT * FROM questions WHERE test_id = ?");
        $stmt->execute([$testId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAnswerByStudent(int $studentId): array
    {
        $this->validateStudentId($studentId); 

        $stmt = $this->db->prepare("SELECT t.title, a.score, a.created_at 
            FROM answers a JOIN tests t ON a.test_id = t.id 
            JOIN users u ON a.student_id = u.id WHERE u.id = ?");
        $stmt->execute([$studentId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAvailableTestsForStudent(int $studentId): array 
    {
        $this->validateStudentId($studentId); 

        $stmt = $this->db->prepare("SELECT t.id, t.title, t.description
            FROM tests t LEFT JOIN answers a ON t.id = a.test_id AND a.student_id = ? WHERE a.id IS NULL");
        $stmt->execute([$studentId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function sendTestResult(int $testId, int $studentId, float $score): void
    {
        $this->validateTestId($testId); 
        $this->validateStudentId($studentId); 

        $stmt = $this->db->prepare("INSERT INTO answers (test_id, student_id, score) VALUES (?, ?, ?)");
        if (!$stmt->execute([$testId, $studentId, $score])) {
            error_log("Ошибка при отправке результата теста: " . implode(", ", $stmt->errorInfo()));
            throw new Exception("Не удалось сохранить результат теста.");
        }
    }

    private function validateTestId(int $testId): void
    {
        if ($testId <= 0) {
            throw new InvalidArgumentException("Некорректный идентификатор теста.");
        }
    }

    private function validateStudentId(int $studentId): void
    {
        if ($studentId <= 0) {
            throw new InvalidArgumentException("Некорректный идентификатор студента.");
        }
    }

    private function validateTeacherId(int $teacherId): void
    {
        if ($teacherId <= 0) {
            throw new InvalidArgumentException("Некорректный идентификатор учителя.");
        }
    }

    private function validateQuestion(array $question): void
    {
        if (empty($question['text']) || !isset($question['correct'])) {
            throw new InvalidArgumentException("Каждый вопрос должен иметь текст и правильный ответ.");
        }
    }
}
