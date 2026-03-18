<?php
// Minimal PHPMailer wrapper. Assumes PHPMailer is installed via Composer.
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../../vendor/autoload.php';

function send_email($to, $subject, $body, $isHtml = true)
{
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = getenv('SMTP_HOST') ?: 'smtp.example.com';
        $mail->SMTPAuth = true;
        $mail->Username = getenv('SMTP_USER') ?: 'user@example.com';
        $mail->Password = getenv('SMTP_PASS') ?: 'password';
        $mail->SMTPSecure = getenv('SMTP_SECURE') ?: 'tls';
        $mail->Port = getenv('SMTP_PORT') ?: 587;

        $mail->setFrom(getenv('SMTP_FROM') ?: 'noreply@example.com', getenv('SMTP_FROM_NAME') ?: 'SmartWebBuilder');
        $mail->addAddress($to);
        $mail->isHTML($isHtml);
        $mail->Subject = $subject;
        $mail->Body = $body;

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log('Mailer Error: ' . $mail->ErrorInfo);
        return false;
    }
}
