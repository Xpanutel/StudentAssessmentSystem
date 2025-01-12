<?php

class FileUploadService {
    private PDO $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function saveFile($student_id, $filePath, $filesize): bool 
    {
        $stmt = $this->db->prepare("INSERT INTO practical_work (student_id, file_path, file_size, score) VALUES (?, ?, ?, 5)");
        return $stmt->execute([
            $student_id, $filePath, $filesize
        ]);
    }
}