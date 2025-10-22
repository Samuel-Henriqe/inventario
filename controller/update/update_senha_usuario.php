<?php
session_start();
require "../conecta_bd.php"; // Aqui deve conter a conexão PDO em $conn
require "..conecta_email.php";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require_once '../../vendor/autoload.php'; // ou ajuste o caminho se não usar composer

if(isset($_POST['email'], $_POST['enviar_codigo'])){
    $email = $_POST['email'];
    $mail = new PHPMailer(true);
    $mail->SMTPDebug = 2;  
    $mail->isSMTP();
    try{
        $codigo = mt_rand(100000, 999999); // Aumentado para 6 dígitos
        $data_envio = date("Y-m-d H:i:s");
        $titulo = 'Redefinição de Senha';
        $assunto = '<p>Seu código para redefinição de senha é: <strong>' .$codigo.   '</strong></p>';
        
        // Configurações do email (assumindo que $mail já foi configurado em conecta_email.php)
        // Exemplo:
        // $mail->isSMTP();
        // $mail->Host = 'smtp.example.com';
        // $mail->SMTPAuth = true;
        // $mail->Username = 'user@example.com';
        // $mail->Password = 'secret';
        // $mail->SMTPSecure = 'tls';
        // $mail->Port = 587;

        $mail->setFrom('nao-responda@seu-dominio.com', 'Sistema de Inventário');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = $titulo;
        $mail->Body    = $assunto;

        // Preparar a consulta SQL
        $sql = "INSERT INTO redefinir_senha (email, codigo, data_envio) VALUES (:email, :codigo, :data_envio)";

        // Preparando a execução da consulta
        $stmt = $conn->prepare($sql);

        // Bindando os parâmetros de maneira segura
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':codigo', $codigo);
        $stmt->bindParam(':data_envio', $data_envio);
        
        // Executar a consulta
        $stmt->execute();
        
        $mail->send();
        echo 'Código de verificação enviado para o seu email!';

    } catch (\Exception $e) {
        echo "Não foi possível enviar o email. Erro: {$mail->ErrorInfo}";
    }

}else if(isset($_POST['email'], $_POST['codigo'], $_POST['validar_codigo'])){
    $email = $_POST['email'];
    $codigo = $_POST['codigo'];
    
    try{
        //seleciona o codigo mais recente para o email informado
        $sql = "SELECT * FROM redefinir_senha WHERE email = :email AND codigo = :codigo ORDER BY data_envio DESC LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':codigo', $codigo);
        $stmt->execute();
        
        $consulta = $stmt->fetch(PDO::FETCH_ASSOC);

         if($consulta){
            // O código é válido. Armazena o email na sessão para o próximo passo.
            $_SESSION['email_redefinir_senha'] = $email;
            echo 'codigo_valido';
         }else{
            echo 'Código inválido ou expirado.';
         }

    } catch (\Exception $e) {
        echo "Erro ao validar o código.";
    }

}else if(isset($_POST['senha'], $_POST['confirma_senha'], $_POST['update_senha'])){
    if(!isset($_SESSION['email_redefinir_senha'])){
        echo "Sessão inválida ou expirada. Por favor, valide o código novamente.";
        exit;
    }
    $email = $_SESSION['email_redefinir_senha'];

    $senha = $_POST['senha'];
    $confirma_senha = $_POST['confirma_senha'];
    
    if($senha === $confirma_senha){
        try{    
            // É crucial criptografar a senha antes de salvar no banco de dados
            $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

            $sql = "UPDATE usuario SET senha = :senha WHERE email = :email";

            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':senha', $senha_hash);
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            if($stmt->rowCount() > 0){
                echo 'Senha atualizada com sucesso!';
                unset($_SESSION['email_redefinir_senha']); // Limpa a sessão após o uso
            } else {
                echo 'Não foi possível atualizar a senha. Usuário não encontrado.';
            }

        } catch(\Exception $e) {
            echo "Erro ao atualizar a senha.";
        }
    }else{
        echo 'As senhas não conferem.';
    }

}else{
    echo "dados incompletos!";
}
?>