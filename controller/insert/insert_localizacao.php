<?php
require "../conecta_bd.php"; // Aqui deve conter a conexão PDO em $conn

// Verifica se todos os dados esperados foram enviados
if (
    isset($_POST["nome"]) && isset($_POST["descricao"])
) {
    // Acessa os valores com segurança
    $nome = $_POST["nome"];
    $descricao = $_POST["descricao"];


    try {
        // Inserir item na tabela "localizacoes"
        $sql = "INSERT INTO localizacoes (
           nome, descricao
        ) VALUES (
            :nome, :descricao
        )";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':descricao', $descricao);

        $stmt->execute();

        echo json_encode(["sucesso" => true, "mensagem" => "localização inserido com sucesso"]);
    } catch (Exception $e) {
        echo json_encode(["erro" => $e->getMessage()]);
    }
} else {
    echo json_encode(["erro" => "Dados incompletos enviados"]);
    exit;
}
?>
