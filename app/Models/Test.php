<?php

class Test 
{
    private $db;

    public function __construct($db) 
    {   
        $this->db = $db;
    }

    public function createTest(string $title, string $description, int $created_by): void 
    {
        $stmt = $this->db->prepare("INSERT INTO tests (title, description, created_by) VALUES (:title, :description, :created_by)");
        $stmt->execute([
            ':title' => $title,
            ':description' => $description,
            ':created_by' => $created_by
        ]);
    }

    public function getTestsByTeacher(string $username): array 
    {
        $stmt = $this->db->prepare("SELECT * FROM tests t JOIN users u 
        ON t.created_by = u.id WHERE u.username = :username ; ");
        $stmt->execute([':username' => $username]);

        $tests = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // Создаем объект Test, передавая все необходимые параметры
            $tests[] = [
                'id' => $row['id'],
                'title' => $row['title'],
                'description' => $row['description'],
                'created_by' => $row['created_by'],
                'created_at' => $row['created_at'],
                'updated_at' => $row['updated_at'],
            ];
        }
        return $tests;
    }


    public function getResultsByTest(int $testId): void 
    {
        $stmt = $this->db->prepare("SELECT * FROM results WHERE test_id = :test_id");
        $stmt->execute([':test_id' => $testId]);
    }
}