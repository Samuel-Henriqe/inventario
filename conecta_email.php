<?
$titulo = '';
$assunto = '';
$fim = '';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // ou ajuste o caminho se não usar composer

$mail = new PHPMailer(true);

try {
    // Configurações do servidor SMTP
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';       // Servidor SMTP
    $mail->SMTPAuth   = true;
    $mail->Username   = 'inventario@gmail.com';   // Seu e-mail
    $mail->Password   = '12345678'; // Sua senha ou senha de app
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // ou PHPMailer::ENCRYPTION_SMTPS
    $mail->Port       = 587; // 465 para SMTPS

    // Remetente e destinatário
    $mail->setFrom('inventario@gmail.com', 'Inventario');
    $mail->addAddress('$destino', 'Destinatário');

    // Conteúdo do e-mail
    $mail->isHTML(true);
    // titulo
    $mail->Subject = $titulo; 
    // assunto
    $mail->Body    = $assunto;
    // rodapé
    $mail->AltBody = $fim;

   
    
} catch (Exception $e) {
    echo "Erro ao enviar e-mail: {$mail->ErrorInfo}";
}
