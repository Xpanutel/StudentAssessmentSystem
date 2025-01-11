<?php

class Test
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function createTest(string $title, string $description, int $createdBy, array $questions): void
    {
        try {
            $stmt = $this->db->prepare("INSERT INTO tests (title, description, created_by) VALUES (?, ?, ?)");
            $stmt->execute([$title, $description, $createdBy]);
            $testId = $this->db->lastInsertId();

            foreach ($questions as $question) {
                if (empty($question['text']) || !isset($question['correct'])) {
                    throw new Exception("Каждый вопрос должен иметь текст и правильный ответ.");
                }
                $stmt = $this->db->prepare("INSERT INTO questions (test_id, question_text, correct_answer) VALUES (?, ?, ?)");
                if (!$stmt->execute([$testId, $question['text'], $question['correct']])) {
                    error_log("Ошибка при добавлении вопроса: " . implode(", ", $stmt->errorInfo()));
                }
            }
        } catch (Exception $e) {
            error_log("Ошибка при создании теста: " . $e->getMessage());
            throw new Exception("Не удалось создать тест. Пожалуйста, попробуйте еще раз.");
        }
    }

    public function getTestsByTeacher(int $teacherId): array
    {
        if ($teacherId <= 0) {
            throw new Exception("Некорректный идентификатор учителя.");
        }
        $stmt = $this->db->prepare("SELECT * FROM tests WHERE created_by = ?");
        $stmt->execute([$teacherId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTestById(int $testId): array
    {
        if ($testId <= 0) {
            throw new Exception("Некорректный идентификатор теста.");
        }
        $stmt = $this->db->prepare("SELECT * FROM tests WHERE id = ?");
        $stmt->execute([$testId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getQuestionsByTestId(int $testId): array
    {
        if ($testId <= 0) {
            throw new Exception("Некорректный идентификатор теста.");
        }
        $stmt = $this->db->prepare("SELECT * FROM questions WHERE test_id = ?");
        $stmt->execute([$testId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAnswerByStudent(int $studentID): array
    {
        if ($studentID <= 0) {
            throw new Exception("Некорректный идентификатор студента.");
        }
        $stmt = $this->db->prepare("SELECT t.title, a.score, a.created_at 
            FROM answers a JOIN tests t ON a.test_id = t.id 
            JOIN users u ON a.student_id = u.id WHERE u.id = ?");
        $stmt->execute([$studentID]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAvailableTestsForStudent(int $studentID): array 
    {
        if ($studentID <= 0) {
            throw new Exception("Некорректный идентификатор студента.");
        }
        $stmt = $this->db->prepare("SELECT t.id, t.title, t.description
            FROM tests t LEFT JOIN answers a ON t.id = a.test_id AND a.student_id = ? WHERE a.id IS NULL");
        $stmt->execute([$studentID]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
