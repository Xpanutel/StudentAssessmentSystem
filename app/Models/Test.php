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
            $this->db->beginTransaction();
            $stmt = $this->db->prepare("INSERT INTO tests (title, description, created_by) VALUES (?, ?, ?)");
            $stmt->execute([$title, $description, $createdBy]);
            $testId = $this->db->lastInsertId();

            foreach ($questions as $index => $question) {
                if (empty($question['text']) || empty($question['correct'])) {
                    throw new InvalidArgumentException("Вопрос {$index} должен содержать текст и правильный ответ.");
                }
            
                error_log("Вставка вопроса с test_id: {$testId}, вопрос: {$question['text']}, правильный ответ: {$question['correct']}");
                $stmt = $this->db->prepare("INSERT INTO questions (test_id, question_text, correct_answer) VALUES (?, ?, ?)");
                $stmt->execute([$testId, $question['text'], $question['correct']]);
            }
            $this->db->commit();
        } catch (Exception $e) {
            $this->db->rollBack(); 
            error_log("Ошибка при создании теста: " . $e->getMessage());
            throw new Exception("Не удалось создать тест. Пожалуйста, попробуйте еще раз." . $e->getMessage());
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
        $stmt = $this->db->prepare("SELECT * FROM questions WHERE test_id = ?");
        $stmt->execute([$testId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAnswerByStudent(int $studentId): array
    {
        $stmt = $this->db->prepare("SELECT t.title, a.score, a.created_at 
            FROM answers a JOIN tests t ON a.test_id = t.id 
            JOIN users u ON a.student_id = u.id WHERE u.id = ?");
        $stmt->execute([$studentId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAvailableTestsForStudent(int $studentId): array 
    {
        $stmt = $this->db->prepare("SELECT t.id, t.title, t.description
            FROM tests t LEFT JOIN answers a ON t.id = a.test_id AND a.student_id = ? WHERE a.id IS NULL");
        $stmt->execute([$studentId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function sendTestResult(int $testId, int $studentId, float $score): void
    {
        $stmt = $this->db->prepare("INSERT INTO answers (test_id, student_id, score) VALUES (?, ?, ?)");
        if (!$stmt->execute([$testId, $studentId, $score])) {
            error_log("Ошибка при отправке результата теста: " . implode(", ", $stmt->errorInfo()));
            throw new Exception("Не удалось сохранить результат теста.");
        }
    }

    public function getResultTestById(int $testId): array 
    {
        $stmt = $this->db->prepare("SELECT tests.id, tests.title AS test_title, users.username AS student_name, answers.created_at AS date_taken, answers.score,
            answers.student_id FROM answers JOIN tests ON answers.test_id = tests.id JOIN users ON answers.student_id = users.id 
            WHERE users.role = 'student' AND tests.id = ?;");
        $stmt->execute([$testId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPracticalWorkByStudentId(int $studentId, int $testId): array 
    {
        $stmt = $this->db->prepare("SELECT pw.*, u.username 
                                  FROM practical_work pw 
                                  JOIN users u ON pw.student_id = u.id 
                                  WHERE pw.student_id = ? AND pw.test_id = ?");
        $stmt->execute([$studentId, $testId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function saveFile(int $student_id, int $testId, string $filePath, int $filesize): bool 
    {
        $stmt = $this->db->prepare("INSERT INTO practical_work (student_id, test_id, file_path, file_size, score) VALUES (?, ?, ?, ?, 5)");
        return $stmt->execute([
            $student_id, $testId, $filePath, $filesize
        ]);
    }
}
