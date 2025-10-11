<?php
require "../conecta_bd.php"; // Aqui deve conter a conexão PDO em $conn
require "../conecta_email.php";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php'; // ou ajuste o caminho se não usar composer

if(isset($_POST['email'], $_POST['enviar_codigo'])){
    $email = $_POST['email'];
    $senha = $_POST['envia_codigo'];
    $mail = new PHPMailer(true);

    try{
        $codigo = mt_rand(1000, 9999);
        $data_envio = date("data, hora, minuto, segundo");
        $titulo = 'Redefinir senha de login';
        $assunto = '<p>Seu código:' .$codigo.   '</p>';
        $fim = 'email senha';
        // Preparar a consulta SQL
        $sql = "insert into redefnir_senha (email, codigo, data_envio) values (:email, :codigo, :data_envio)";

        // Preparando a execução da consulta
        $stmt = $conn->prepare($sql);

        // Bindando os parâmetros de maneira segura
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':codigo', $codigo);
        // Executar a consulta
        $stmt->execute();
        echo 'Codigo inserido no bd com sucesso!';

        $mail->send();
    } catch (Exception $e) {
        echo "dados incompletos";
    }

}else{
    echo "dados incompletos!";
}

if(isset($_POST['codigo'], $_POST['validar_codigo'])){
    // primeiro apagar registros de codigo e email

    $codigo = $_POST['codigo'];
    $senha = $_POST['validar_codigo'];
    
    try{
        
        //seleciona o mais recente
        $sql = "select * from redefinir_senha where email = :email and codigo = :codigo latest";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        // Obter os resultados como array associativo
         $consulta = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // Retornar os dados em formato JSON
        $stmt->execute();
        echo 'Codigo inserido no bd com sucesso!';
         echo json_encode($codigo);

         if($consulta['codigo'] === $codigo ){
            echo 'redefinir senha';
           // redefinir_senha
         }else{
            echo 'os codigos não conferem';
         }

    } catch (Exception $e) {
        echo "dados incompletos";
    }

}else{
    echo "dados incompletos!";
}

if(isset($_POST['senha'], $_POST['confirma_senha'],$_POST['update_senha'] )){
    $senha = $_POST['senha'];
    $confirma_senha = $_POST['confirma_senha'];
    
    if($senha === $confirma_senha){
        try{    
        $sql = "update usuario set senha = :senha";

         $stmt = $conn->prepare($sql);
         $stmt->execute();

        // Obter os resultados como array associativo
    

        // Retornar os dados em formato JSON
        $stmt->execute();
        echo 'Senha atualizada com sucesso!';
        

    } catch(Exception $e) {
        echo "dados incompletos";
    }
    }else{
        echo 'as senha não conferem';
    }

}else{
    echo "dados incompletos!";
}
?>