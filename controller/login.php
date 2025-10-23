<?php
session_start();


require "conecta_bd.php";

if (isset($_POST["usuario"]) && isset($_POST["senha"])) {
    $usuario = $_POST["usuario"];
    $senha = $_POST["senha"];
    
    try {
        $sql = "SELECT * FROM usuario WHERE email = :usuario";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':usuario', $usuario);
        $stmt->execute();

        $login = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Verificar se usuário existe e senha confere
        if ($login && password_verify($senha, $login['senha'])) {
            $_SESSION['siape'] = $login['siape'];
            $_SESSION['cargo'] = $login['cargo'];
            $_SESSION['usuario_logado'] = true;

            // Redirecionamento direto para home
            header("Location: ../view/home.php");
            exit();
        } else {
            // Volta para login com erro
            $_SESSION['erro_login'] = "Usuário ou senha inválidos";
            header("Location: ../index.php");
            exit();
        }
    } catch (PDOException $e) {
        $_SESSION['erro_login'] = "Erro no servidor: " . $e->getMessage();
        header("Location: ../index.php");
        exit();
    }
} else {
    $_SESSION['erro_login'] = "Os campos 'usuario' e 'senha' devem ser preenchidos.";
    header("Location: ../index.php");
    exit();
}
?>
