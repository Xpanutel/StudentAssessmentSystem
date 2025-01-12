<?php

class FileUploadController {
    private FileUploadService $fileUploadService;

    public function __construct(FileUploadService $fileUploadService) {
        $this->fileUploadService = $fileUploadService;
    }

    public function upload(array $requestData): void {
        try {
            $file = $_FILES['image'];

            if ($file['error'] !== UPLOAD_ERR_OK) {
                throw new RuntimeException('Ошибка загрузки файла.');
            }

            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            if (!in_array($file['type'], $allowedTypes, true)) {
                throw new InvalidArgumentException('Допустимы только изображения.');
            }

            $this->saveFile($file, $_SESSION['user']['id']);
            header('Location: /success');
            exit;

        } catch (Exception $e) {
            $this->handleError($e->getMessage(), '/upload');
        }
    }

    private function saveFile(array $file): void {
        $uploadDir = __DIR__ . '/../../uploads/';
        $fileName = basename($file['name']);
        $filePath = $uploadDir . $fileName;

        if (!is_dir($uploadDir) || !is_writable($uploadDir)) {
            throw new RuntimeException('Директория загрузки недоступна.');
        }

        if (!move_uploaded_file($file['tmp_name'], $filePath)) {
            throw new RuntimeException('Не удалось переместить загруженный файл.');
        }

        if (!$this->fileUploadService->saveFile($_SESSION['user']['id'], $fileName, $file['size'])) {
            throw new RuntimeException('Не удалось сохранить информацию о файле.');
        }
    }

    private function handleError(string $message, string $redirectUrl): void {
        $_SESSION['error_message'] = $message;
        header("Location: $redirectUrl");
        exit;
    }
}
