<?php
require "../conecta_bd.php";

if (
    isset($_POST["id_localizacao"], $_POST["nome_local"], $_POST["descricao_local"], $_POST["resposavel"])
) {
    // Pegando os dados da requisição
    $id_localizacao = $_POST["id_localizacao"];
    $nome_local = $_POST["nome_local"];
    $descricao_local = $_POST["descricao_local"];
    $resposavel = $_POST["resposavel"];

    try {
        // Preparar a consulta SQL
        $sql = "UPDATE item SET 
                    nome_local = COALESCE(NULLIF(:nome_local, ''), nome_local),
                    descricao_local = COALESCE(NULLIF(:descricao_local, ''), descricao_local),
                    resposavel = COALESCE(NULLIF(:resposavel, ''), resposavel)
                WHERE id_localizacao = :id_localizacao";

        // Preparando a execução da consulta
        $stmt = $conn->prepare($sql);

        // Bindando os parâmetros de maneira segura
        $stmt->bindParam(':nome_local', $nome_local);
        $stmt->bindParam(':descricao_local', $descricao_local);
        $stmt->bindParam(':resposavel', $resposavel);
        $stmt->bindParam(':id_localizacao', $id_localizacao);

        // Executar a consulta
        $stmt->execute();

        // Verificar se alguma linha foi afetada
        if ($stmt->rowCount() > 0) {
            echo json_encode(["sucesso" => true, "mensagem" => "Item atualizado com sucesso"]);
        } else {
            echo json_encode(["erro" => "Nenhum item foi atualizado. Verifique os dados e tente novamente."]);
        }

    } catch (Exception $e) {
        echo json_encode(["erro" => "Erro ao atualizar o item: " . $e->getMessage()]);
    }
} else {
    echo json_encode(["erro" => "Dados incompletos enviados"]);
    exit;
}
?>
