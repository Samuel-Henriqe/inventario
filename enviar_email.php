<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // ou ajuste o caminho se não usar composer

$mail = new PHPMailer(true);

try {
    // Configurações do servidor SMTP
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';       // Servidor SMTP
    $mail->SMTPAuth   = true;
    $mail->Username   = 'seuemail@gmail.com';   // Seu e-mail
    $mail->Password   = 'sua-senha-ou-app-password'; // Sua senha ou senha de app
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // ou PHPMailer::ENCRYPTION_SMTPS
    $mail->Port       = 587; // 465 para SMTPS

    // Remetente e destinatário
    $mail->setFrom('seuemail@gmail.com', 'Seu Nome');
    $mail->addAddress('destinatario@exemplo.com', 'Destinatário');

    // Conteúdo do e-mail
    $mail->isHTML(true);
    $mail->Subject = 'Assunto do E-mail';
    $mail->Body    = '<b>Este é um e-mail de teste enviado via PHPMailer!</b>';
    $mail->AltBody = 'Este é um e-mail de teste enviado via PHPMailer!';

    $mail->send();
    echo 'E-mail enviado com sucesso.';
} catch (Exception $e) {
    echo "Erro ao enviar e-mail: {$mail->ErrorInfo}";
}
