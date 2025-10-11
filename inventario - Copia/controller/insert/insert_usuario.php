<?php
require "../conecta_bd.php"; // Aqui deve conter a conexão PDO em $conn

// Verifica se todos os dados esperados foram enviados
if (
    isset($_POST["siape"], $_POST["nome"], $_POST["cargo"], $_POST["email"], $_POST["senha"])
) {
    // Acessa os valores com segurança
    $siape = $_POST["siape"];
    $nome = $_POST["nome"];
    $cargo = $_POST["cargo"];
    $email = $_POST["email"];
    $senha = $_POST["senha"];

    try {
        // Inserir item na tabela "categoria"
        $sql = "INSERT INTO usuario (
            siape, nome, cargo, email, senha
        ) VALUES (
            :siape, :nome, :cargo, :email, :senha
        )";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':siape', $siape);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':cargo', $cargo);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':senha', $senha);

        $stmt->execute();

        echo json_encode(["sucesso" => true, "mensagem" => "usuairo inserido com sucesso"]);
    } catch (Exception $e) {
        echo json_encode(["erro" => $e->getMessage()]);
    }
} else {
    echo json_encode(["erro" => "Dados incompletos enviados"]);
    exit;
}
?>
