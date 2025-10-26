<?php
session_start();
if(!isset($_SESSION['parte'])) {
    $_SESSION['parte'] = 1;
}

require "../conecta_bd.php"; // conexão em $conn
require "../conecta_email.php";
// require "../conecta_email.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../../vendor/autoload.php';



// === Enviar código ===
// === Enviar código ===
if(isset($_POST['email'], $_POST['enviar_codigo']) && $_SESSION['parte'] == 1){
    $destino = $_POST['email'];
    $codigo = mt_rand(1000, 9999);
    $data_envio = date("Y-m-d H:i:s");

   
    $sql = "SELECT * FROM usuarios WHERE email = :destino";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':destino', $destino);
    $stmt->execute();

    // Verifica se encontrou algum resultado
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario) {
        echo "O email informado existe no banco de dados";
        try{
        // Inserir no banco
        $sql = "INSERT INTO redefinir_senha_usuario (email, codigo, data_envio) VALUES (:email, :codigo, :data_envio)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':email', $destino);
        $stmt->bindParam(':codigo', $codigo);
        $stmt->bindParam(':data_envio', $data_envio);
        $stmt->execute();
        $conn = null;

        // Conteúdo do e-mail
        $titulo  = "Código de redefinição";
        $assunto = "<p>Seu código é: <strong>$codigo</strong></p>";
        $fim     = "Equipe Inventário.";

        // Cria PHPMailer configurado
        require "../conecta_email.php";

        // Adiciona destinatário dinâmico
        $mail->addAddress($destino);

        // Define assunto e corpo
        $mail->Subject = $titulo;
        $mail->Body    = $assunto . "<br><br>$fim";
        $mail->AltBody = strip_tags($assunto . " " . $fim);

        // Envia o e-mail
        $mail->send();

        echo 'Código enviado e inserido no BD com sucesso!';
        $_SESSION['parte'] = 2;
    } catch (Exception $e) {
        echo "Erro ao enviar: " . $e->getMessage();
    }
    exit;
    } else {
        echo "O email informado não existe no banco de dados";
    }

    
}

// === Validar código ===
if(isset($_POST['email'], $_POST['codigo'], $_POST['validar_codigo']) && $_SESSION['parte'] = 2){
    $destino = $_POST['email'];
    $codigo = $_POST['codigo'];

    try{
        $sql = "SELECT * FROM redefinir_senha_usuario 
                WHERE email = :email AND codigo = :codigo 
                ORDER BY data_envio DESC LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':email', $destino);
        $stmt->bindParam(':codigo', $codigo);
        $stmt->execute();
        $consulta = $stmt->fetch(PDO::FETCH_ASSOC);

        if($consulta){
            echo "Código válido!";
            $_SESSION['parte'] = 3;
        } else {
            echo "Código inválido!";
        }

    } catch (Exception $e) {
        echo "Erro: " . $e->getMessage();
    }
    exit;
}


// === Atualizar senha ===
if(isset($_POST['email'], $_POST['senha'], $_POST['confirma_senha'], $_POST['update_senha']) && $_SESSION['parte'] = 2;){
    $destino = $_POST['email'];
    $senha = $_POST['senha'];
    $confirma_senha = $_POST['confirma_senha'];

    if($senha === $confirma_senha){
        try{
            // $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

            $sql = "UPDATE usuarios SET senha = :senha WHERE email = :email";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':senha', $senha);
            $stmt->bindParam(':email', $destino);
            $stmt->execute();

            echo 'Senha atualizada com sucesso!';
        } catch (Exception $e) {
            echo "Erro: " . $e->getMessage();
        }
    }else{
        echo 'As senhas não conferem';
    }
     $_SESSION['parte'] = 1;
    exit;
}
?>
