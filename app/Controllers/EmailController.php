<?php

require 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class EmailController {

    private $config;
    private $mail;

    public function __construct($config) {
        $this->config = $config;
        $this->mail = new PHPMailer(true);
        $this->setupMailer();
    }

    private function setupMailer() {
        $this->mail->isSMTP();
        $this->mail->Host = $this->config['smtp']['host'];
        $this->mail->SMTPAuth = true;
        $this->mail->Username = $this->config['smtp']['username'];
        $this->mail->Password = $this->config['smtp']['password'];
        $this->mail->SMTPSecure = $this->config['smtp']['secure'];
        $this->mail->Port = $this->config['smtp']['port'];
        $this->mail->CharSet = 'UTF-8';
        $this->mail->setFrom($this->config['from']['email'], $this->config['from']['name']);
    }

    // public function sendTestResultToEmail($recipientEmail, $grade, $moduleName, $studentName) {
    //     $this->mail->addAddress($recipientEmail);
    //     $this->mail->isHTML(true);
    //     $this->mail->Subject = 'Результат теста';
    
    //     $this->mail->Body = "
    //     <p>Здравствуйте!</p>
    //     <p>Мы рады сообщить вам, что завершилось прохождение модуля «" . htmlspecialchars($moduleName) . "». Пожалуйста, ознакомьтесь с результатами обучения для «" . htmlspecialchars($studentName) . "».</p>
    //     <p>Результат: <strong>" . htmlspecialchars($grade) . "</strong></p>
    //     ";
    
    //     $this->mail->AltBody = "Здравствуйте!\nМы рады сообщить вам, что завершилось прохождение модуля «" . $moduleName . "». Пожалуйста, ознакомьтесь с результатами обучения для «" . $studentName . "».\nРезультат: " . $grade . ".";
    
    //     if (!$this->mail->send()) {
    //         throw new Exception('Сообщение не было отправлено. Ошибка: ' . $this->mail->ErrorInfo);
    //     }
    // }

    public function sendTestResultsToEmail($recipientEmail, $testGrade, $practicalGrade, $moduleName, $studentName, $fileName) {
        // Получаем путь к директории, где хранятся файлы
        $directory = __DIR__ . '/../../uploads/'; 
        $practicalFilePath = $directory . $fileName;
    
        // Проверяем, существует ли файл
        if (!file_exists($practicalFilePath)) {
            throw new Exception('Файл не найден: ' . $practicalFilePath);
        }
    
        $this->mail->addAddress($recipientEmail);
        $this->mail->isHTML(true);
        $this->mail->Subject = 'Результаты тестирования';
    
        // Формируем тело письма
        $this->mail->Body = "
        <p>Здравствуйте!</p>
        <p>Мы рады сообщить вам, что завершилось прохождение модуля «" . htmlspecialchars($moduleName) . "». Пожалуйста, ознакомьтесь с результатами обучения для «" . htmlspecialchars($studentName) . "».</p>
        <p>Результат за прохождение теста: <strong>" . htmlspecialchars($testGrade) . "</strong></p>
        <p>Результат за применение практических навыков: <strong>" . htmlspecialchars($practicalGrade) . "</strong></p>
        ";
    
        // Добавление файла, если он существует
        if (file_exists($practicalFilePath)) {
            $this->mail->addAttachment($practicalFilePath);
            $this->mail->Body .= "<p>Прикреплен файл с результатами практических навыков.</p>";
        }
    
        // Альтернативное тело письма
        $this->mail->AltBody = "Здравствуйте!\nМы рады сообщить вам, что завершилось прохождение модуля «" . $moduleName . "». Пожалуйста, ознакомьтесь с результатами обучения для «" . $studentName . "».\nРезультат за прохождение теста: " . $testGrade . ".\nРезультат за применение практических навыков: " . $practicalGrade . ".";
    
        // Отправка письма
        if (!$this->mail->send()) {
            throw new Exception('Сообщение не было отправлено. Ошибка: ' . $this->mail->ErrorInfo);
        }
    }      
    
}
