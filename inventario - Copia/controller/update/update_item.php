<?php
require "../conecta_bd.php";

if (
    isset($_POST["numero_tombamento"], $_POST["numero_tombamento"], $_POST["nome_item"], $_POST["descricao_item"],
          $_POST["unidade_de_medida"], $_POST["status_item"], $_POST["data_aquisicao"],
          $_POST["id_categoria"])
) {
    // Pegando os dados da requisição
    $numero_tombamento = $_POST["numero_tombamento"];
    $nome_item = $_POST["nome_item"];
    $descricao_item = $_POST["descricao_item"];
    $unidade_de_medida = $_POST["unidade_de_medida"];
    $status_item = $_POST["status_item"];
    $data_aquisicao = $_POST["data_aquisicao"];
    $id_categoria = $_POST["id_categoria"];

    try {
        // Preparar a consulta SQL
        $sql = "UPDATE item SET 
                    nome_item = COALESCE(NULLIF(:nome_item, ''), nome_item),
                    descricao_item = COALESCE(NULLIF(:descricao_item, ''), descricao_item),
                    unidade_de_medida = COALESCE(NULLIF(:unidade_de_medida, ''), unidade_de_medida),
                    status_item = COALESCE(NULLIF(:status_item, ''), status_item),
                    data_aquisicao = COALESCE(NULLIF(:data_aquisicao, ''), data_aquisicao),
                    id_categoria = COALESCE(NULLIF(:id_categoria, ''), id_categoria)
                WHERE numero_tombamento = :numero_tombamento";

        // Preparando a execução da consulta
        $stmt = $conn->prepare($sql);

        // Bindando os parâmetros de maneira segura
        $stmt->bindParam(':numero_tombamento', $numero_tombamento);
        $stmt->bindParam(':nome_item', $nome_item);
        $stmt->bindParam(':descricao_item', $descricao_item);
        $stmt->bindParam(':unidade_de_medida', $unidade_de_medida);
        $stmt->bindParam(':status_item', $status_item);
        $stmt->bindParam(':data_aquisicao', $data_aquisicao);
        $stmt->bindParam(':id_categoria', $id_categoria);

        // Executar a consulta
        $stmt->execute();

        // Verificar se alguma linha foi afetada (ou seja, se o item foi de fato atualizado)
        if ($stmt->rowCount() > 0) {
            echo json_encode(["sucesso" => true, "mensagem" => "Item atualizado com sucesso"]);
        } else {
            echo json_encode(["erro" => "Nenhum item foi atualizado. Verifique o número de tombamento e tente novamente."]);
        }

    } catch (Exception $e) {
        echo json_encode(["erro" => "Erro ao atualizar o item: " . $e->getMessage()]);
    }
} else {
    echo json_encode(["erro" => "Dados incompletos enviados"]);
    exit;
}
?>
