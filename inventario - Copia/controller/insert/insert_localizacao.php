<?php
require "../conecta_bd.php"; // Aqui deve conter a conexão PDO em $conn

// Verifica se todos os dados esperados foram enviados
if (
    isset($_POST["id_localizacao"], $_POST["nome_local"], $_POST["descricao_local"], $_POST["responsavel"])
) {
    // Acessa os valores com segurança
    $id_localizacao = $_POST["id_localizacao"];
    $nome_local = $_POST["nome_local"];
    $descricao_local = $_POST["descricao_local"];
    $responsavel = $_POST["responsavel"];

    try {
        // Inserir item na tabela "categoria"
        $sql = "INSERT INTO categoria (
            id_localizacao, nome_local, descricao_local, responsavel
        ) VALUES (
            :id_localizacao, :nome_local, :descricao_local, :responsavel
        )";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id_localizacao', $id_localizacao);
        $stmt->bindParam(':nome_local', $nome_local);
        $stmt->bindParam(':descricao_local', $descricao_local);
        $stmt->bindParam(':responsavel', $responsavel);

        $stmt->execute();

        echo json_encode(["sucesso" => true, "mensagem" => "Item inserido com sucesso"]);
    } catch (Exception $e) {
        echo json_encode(["erro" => $e->getMessage()]);
    }
} else {
    echo json_encode(["erro" => "Dados incompletos enviados"]);
    exit;
}
?>
