<?php
require "../conecta_bd.php"; // Conexão PDO em $conn

// Verifica se os dados esperados foram enviados
if (
    isset($_POST["numero_tombamento"], $_POST["nome_item"], $_POST["descricao_item"],
          $_POST["unidade_de_medida"], $_POST["status_item"], $_POST["data_aquisicao"], $_POST["id_categoria"])
) {
    // Pegando os dados da requisição
    $numero_tombamento = trim($_POST["numero_tombamento"]);
    $nome_item         = trim($_POST["nome_item"]);
    $descricao_item    = trim($_POST["descricao_item"]);
    $unidade_medida    = trim($_POST["unidade_de_medida"]);
    $status_item       = trim($_POST["status_item"]);
    $data_aquisicao    = trim($_POST["data_aquisicao"]);
    $id_categoria      = trim($_POST["id_categoria"]);

    try {
        // SQL de atualização com COALESCE para manter valores existentes
        $sql = "UPDATE itens SET 
                    nome = COALESCE(NULLIF(:nome, ''), nome),
                    descricao = COALESCE(NULLIF(:descricao, ''), descricao),
                    unidade_medida = COALESCE(NULLIF(:unidade_medida, ''), unidade_medida),
                    status = COALESCE(NULLIF(:status, ''), status),
                    data_aquisicao = COALESCE(NULLIF(:data_aquisicao, ''), data_aquisicao),
                    id_categoria = COALESCE(NULLIF(:id_categoria, ''), id_categoria)
                WHERE numero_tombamento = :numero_tombamento";

        $stmt = $conn->prepare($sql);

        // Bind seguro dos parâmetros
        $stmt->bindParam(':numero_tombamento', $numero_tombamento);
        $stmt->bindParam(':nome', $nome_item);
        $stmt->bindParam(':descricao', $descricao_item);
        $stmt->bindParam(':unidade_medida', $unidade_medida);
        $stmt->bindParam(':status', $status_item);
        $stmt->bindParam(':data_aquisicao', $data_aquisicao);
        $stmt->bindParam(':id_categoria', $id_categoria);

        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            echo json_encode(["sucesso" => true, "mensagem" => "Item atualizado com sucesso!"]);
        } else {
            echo json_encode(["erro" => "Nenhum item foi atualizado. Verifique o número de tombamento."]);
        }

    } catch (PDOException $e) {
        echo json_encode(["erro" => "Erro ao atualizar o item: " . $e->getMessage()]);
    }

} else {
    echo json_encode(["erro" => "Dados incompletos enviados"]);
    exit;
}
?>
