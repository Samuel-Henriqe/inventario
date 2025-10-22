<?php
require "../conecta_bd.php"; // Aqui deve conter a conexão PDO em $conn

// Verifica se todos os dados esperados foram enviados
if (
    isset($_POST["id_categoria"], $_POST["nome_categoria"], $_POST["descricao_categoria"])
) {
    // Acessa os valores com segurança
    $siape = $_POST["id_categoria"];
    $nome = $_POST["nome_categoria"];
    $cargo = $_POST["descricao_categoria"];


    try {
        // Inserir item na tabela "categoria"
        $sql = "INSERT INTO categoria (
            id_categoria, nome_categoria, descricao_categoria
        ) VALUES (
            :id_categoria, :nome_categoria, :descricao_categoria
        )";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id_categoria', $id_categoria);
        $stmt->bindParam(':nome_categoria', $nome_categoria);
        $stmt->bindParam(':descricao_categoria', $descricao_categoria);


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
