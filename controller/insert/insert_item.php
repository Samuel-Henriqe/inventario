<?php
require "../conecta_bd.php"; // Conexão PDO deve estar em $conn

if (
    isset($_POST["numero_patrimonio"], $_POST["nome_item"], $_POST["descricao_item"],
          $_POST["data_aquisicao"], $_POST["id_local"], $_POST["id_categoria"], $_POST["status_item"])
) {
    // Coletar dados do formulário
    $numero_patrimonio = $_POST["numero_patrimonio"];
    $nome_item = $_POST["nome_item"];
    $descricao_item = $_POST["descricao_item"];
    $status_item = $_POST["status_item"];
    $data_aquisicao = $_POST["data_aquisicao"];
    $id_localizacao = $_POST["id_local"];
    $id_categoria = $_POST["id_categoria"];

    try {
        // Inserir item na tabela `itens`
        $sql = "INSERT INTO itens (
                    nome,
                    descricao,
                    numero_patrimonio,
                    id_categoria,
                    id_localizacao,
                    status,
                    data_aquisicao,
                    id_usuario_cadastro
                ) VALUES (
                    :nome,
                    :descricao,
                    :numero_patrimonio,
                    :id_categoria,
                    :id_localizacao,
                    :status,
                    :data_aquisicao,
                    :id_usuario_cadastro
                )";

        $stmt = $conn->prepare($sql);

        // Aqui, defina o ID do usuário logado (exemplo: 1 se ainda não tem sessão)
        $id_usuario_cadastro = 1;

        // Bind dos parâmetros
        $stmt->bindParam(':nome', $nome_item);
        $stmt->bindParam(':descricao', $descricao_item);
        $stmt->bindParam(':numero_patrimonio', $numero_patrimonio);
        $stmt->bindParam(':id_categoria', $id_categoria, PDO::PARAM_INT);
        $stmt->bindParam(':id_localizacao', $id_localizacao, PDO::PARAM_INT);
        $stmt->bindParam(':status', $status_item);
        $stmt->bindParam(':data_aquisicao', $data_aquisicao);
        $stmt->bindParam(':id_usuario_cadastro', $id_usuario_cadastro, PDO::PARAM_INT);

        $stmt->execute();

        echo json_encode(["sucesso" => true, "mensagem" => "Item inserido com sucesso!"]);

    } catch (Exception $e) {
        echo json_encode(["erro" => "Erro ao inserir: " . $e->getMessage()]);
    }

} else {
    echo json_encode(["erro" => "Dados incompletos enviados"]);
    exit;
}
?>
