<?php
require "../conecta_bd.php";

if (
    isset($_POST["numero_tombamento"], $_POST["nome_item"], $_POST["descricao_item"],
          $_POST["unidade_de_medida"], $_POST["status_item"], $_POST["data_aquisicao"],
          $_POST["id_categoria"])
) {
    // Agora sim: podemos acessar os valores com segurança
    $numero_tombamento = $_POST["numero_tombamento"];
    $nome_item = $_POST["nome_item"];
    $descricao_item = $_POST["descricao_item"];
    $unidade_de_medida = $_POST["unidade_de_medida"];
    $status_item = $_POST["status_item"];
    $data_aquisicao = $_POST["data_aquisicao"];
    $id_categoria = $_POST["id_categoria"];
    
    try {
        // Atualizar item
        $sql = "UPDATE item 
                SET nome_item = :nome_item, 
                    descricao_item = :descricao_item,
                    unidade_de_medida = :unidade_de_medida,
                    status_item = :status_item, 
                    data_aquisicao = :data_aquisicao,
                    id_categoria = :id_categoria
                WHERE numero_tombamento = :numero_tombamento";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':numero_tombamento', $numero_tombamento);
        $stmt->bindParam(':nome_item', $nome_item);
        $stmt->bindParam(':descricao_item', $descricao_item);
        $stmt->bindParam(':unidade_de_medida', $unidade_de_medida);
        $stmt->bindParam(':status_item', $status_item);
        $stmt->bindParam(':data_aquisicao', $data_aquisicao);
        $stmt->bindParam(':id_categoria', $id_categoria);

        $stmt->execute();

        echo json_encode(["sucesso" => true, "mensagem" => "Item atualizado com sucesso"]);

    } catch (Exception $e) {
        echo json_encode(["erro" => $e->getMessage()]);
    }
} else {
    echo json_encode(["erro" => "Dados incompletos enviados"]);
    exit;
}
?>
