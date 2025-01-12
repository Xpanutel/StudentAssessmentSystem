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

    public function sendTestResultToEmail($recipientEmail, $grade, $moduleName, $studentName) {
        $this->mail->addAddress($recipientEmail);
        $this->mail->isHTML(true);
        $this->mail->Subject = 'Результат теста';
    
        $this->mail->Body = "
        <p>Здравствуйте!</p>
        <p>Мы рады сообщить вам, что завершилось прохождение модуля «" . htmlspecialchars($moduleName) . "». Пожалуйста, ознакомьтесь с результатами обучения для «" . htmlspecialchars($studentName) . "».</p>
        <p>Результат: <strong>" . htmlspecialchars($grade) . "</strong></p>
        ";
    
        $this->mail->AltBody = "Здравствуйте!\nМы рады сообщить вам, что завершилось прохождение модуля «" . $moduleName . "». Пожалуйста, ознакомьтесь с результатами обучения для «" . $studentName . "».\nРезультат: " . $grade . ".";
    
        if (!$this->mail->send()) {
            throw new Exception('Сообщение не было отправлено. Ошибка: ' . $this->mail->ErrorInfo);
        }
    }
    
}
