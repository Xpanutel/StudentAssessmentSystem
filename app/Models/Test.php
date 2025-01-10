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
        $stmt = $this->db->prepare("SELECT * FROM tests WHERE created_by = ?");
        $stmt->execute([$teacherId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTestById(int $testId): array
    {
        $stmt = $this->db->prepare("SELECT * FROM tests WHERE id = ?");
        $stmt->execute([$testId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getQuestionsByTestId(int $testId): array
    {
        $stmt = $this->db->prepare("SELECT * FROM questions WHERE test_id = ? ");
        $stmt->execute([$testId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAnswerByStudent(int $studentID): array
    {
        $stmt = $this->db->prepare("SELECT * FROM answers WHERE student_id = ?");
        $stmt->execute([$studentID]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
