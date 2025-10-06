<?php


require "conecta_bd.php";

header('Content-Type: application/json');
print_r($_POST);

if (isset($_POST["usuario"]) && isset($_POST["senha"])) {
    $usuario = $_POST["usuario"];
    $senha = $_POST["senha"];
    
    try {
        $sql = "SELECT * FROM usuario WHERE email = :usuario";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':usuario', $usuario);
        $stmt->execute();

        $login = $stmt->fetch(PDO::FETCH_ASSOC);
        // && password_verify($senha, $login['senha'])
        if ($login) {
            $cargo = $login['cargo'];
            echo json_encode(["Login" => true, "cargo" => $cargo]);
            if($cargo ){
                header("Location: ../view/home.php");
            }
            
        } else {
            echo json_encode(["Login" => false, "erro" => "Usuário ou senha inválidos"]);
        }
    } catch (PDOException $e) {
        echo json_encode(["Login" => false, "erro" => "Erro no servidor: " . $e->getMessage()]);
    }
} else {
    echo json_encode(["Login" => false, "erro" => "Os campos 'usuario' e 'senha' não foram preenchidos."]);
}
?>
