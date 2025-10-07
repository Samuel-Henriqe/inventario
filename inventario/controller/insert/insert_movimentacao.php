<?php
session_start(); // Adicionado para usar $_SESSION

require "../conecta_bd.php";

if (
    isset($_POST["tipo_movimentacao"]) && 
    isset($_POST["id_local_origem"]) && 
    isset($_POST["id_local_destino"]) && 
    isset($_POST["numero_tombamento"]) && 
    isset($_SESSION["siape"])
) {
    $tipo_movimentacao = $_POST['tipo_movimentacao'];
    $data_movimentacao = date("Y-m-d");
    $siape = $_SESSION["siape"];
    $id_local_origem = $_POST["id_local_origem"]; // Corrigido $_POS
    $id_local_destino = $_POST["id_local_destino"];
    $numero_tombamento = $_POST["numero_tombamento"];
    $quantidade = 1; // Você pode ajustar esse valor conforme necessário

    try {
        // Inserir na tabela movimentacao (sem id_movimentacao, pois é AUTO_INCREMENT)
        $sql = "INSERT INTO movimentacao (
            tipo_movimentacao, data_movimentacao,
            siape, id_local_origem, id_local_destino
        ) VALUES (
            :tipo_movimentacao, :data_movimentacao,
            :siape, :id_local_origem, :id_local_destino
        )";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':tipo_movimentacao', $tipo_movimentacao);
        $stmt->bindParam(':data_movimentacao', $data_movimentacao);
        $stmt->bindParam(':siape', $siape);
        $stmt->bindParam(':id_local_origem', $id_local_origem);
        $stmt->bindParam(':id_local_destino', $id_local_destino);
        $stmt->execute();

        // Pegar o ID da movimentação recém-inserida
        $id_movimentacao = $conn->lastInsertId();

        // Inserir na tabela movimentacao_item
        $sql = "INSERT INTO movimentacao_item (
            id_movimentacao, numero_tombamento, quantidade
        ) VALUES (
            :id_movimentacao, :numero_tombamento, :quantidade
        )";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id_movimentacao', $id_movimentacao);
        $stmt->bindParam(':numero_tombamento', $numero_tombamento);
        $stmt->bindParam(':quantidade', $quantidade);
        $stmt->execute();

        echo json_encode([
            "sucesso" => true, 
            "mensagem" => "Movimentação e item inseridos com sucesso",
            "id_movimentacao" => $id_movimentacao
        ]);
    } catch (Exception $e) {
        echo json_encode([
            "sucesso" => false,
            "erro" => "Erro ao inserir movimentação: " . $e->getMessage()
        ]);
    }
} else {
    echo json_encode([
        "sucesso" => false,
        "erro" => "Dados incompletos"
    ]);
}
?>
