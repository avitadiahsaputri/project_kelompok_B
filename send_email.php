<?php
include 'koneksi.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/vendor/autoload.php';

function sendVerificationCodeByEmail($email, $data_text) {
    global $config;
    $smtp = $config['smtp'] ?? [];
    if (empty($smtp['host']) || empty($smtp['username'])) {
        return false;
    }

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = $smtp['host'];
        $mail->SMTPAuth = true;
        $mail->Username = $smtp['username'];
        $mail->Password = $smtp['password'] ?? '';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = $smtp['port'] ?? 587;

        $mail->setFrom($smtp['from'] ?? $smtp['username'], $smtp['from_name'] ?? 'Admin Evoting');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = 'Informasi Akun Admin';
        $mail->Body = nl2br($data_text);

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}
?>
