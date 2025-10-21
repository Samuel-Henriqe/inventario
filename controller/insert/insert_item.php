<?php
require "../conecta_bd.php"; // Aqui deve conter a conexão PDO em $conn

if (
    isset($_POST["numero_tombamento"], $_POST["nome_item"], $_POST["descricao_item"],
          $_POST["unidade_de_medida"], $_POST["status_item"], $_POST["data_aquisicao"],
          $_POST["id_localizacao"], $_POST["id_categoria"])
) {
    // Agora sim: podemos acessar os valores com segurança
    $numero_tombamento = $_POST["numero_tombamento"];
    $nome_item = $_POST["nome_item"];
    $descricao_item = $_POST["descricao_item"];
    $unidade_de_medida = $_POST["unidade_de_medida"];
    $status_item = $_POST["status_item"];
    $data_aquisicao = $_POST["data_aquisicao"];
    $id_localizacao = $_POST["id_localizacao"];
    $id_categoria = $_POST["id_categoria"];

    // ... continua com o restante do seu código
    try {
    

    // Inserir item
    $sql = "INSERT INTO item (
        numero_tombamento, nome_item, descricao_item,
        unidade_de_medida, status_item, data_aquisicao,
        id_categoria, id_localizacao
    ) VALUES (
        :numero_tombamento, :nome_item, :descricao_item,
        :unidade_de_medida, :status_item, :data_aquisicao,
        :id_categoria, :id_localizacao
    )";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':numero_tombamento', $numero_tombamento);
    $stmt->bindParam(':nome_item', $nome_item);
    $stmt->bindParam(':descricao_item', $descricao_item);
    $stmt->bindParam(':unidade_de_medida', $unidade_de_medida);
    $stmt->bindParam(':status_item', $status_item);
    $stmt->bindParam(':data_aquisicao', $data_aquisicao);
    $stmt->bindParam(':id_categoria', $id_categoria);
    $stmt->bindParam(':id_localizacao', $id_localizacao);

    $stmt->execute();

    echo json_encode(["sucesso" => true, "mensagem" => "Item inserido com sucesso"]);
    header("location: ../../view/cadastro-lista-itens.php?cadastro=sucesso");

} catch (Exception $e) {
    echo json_encode(["erro" => $e->getMessage()]);
}
}
else {
    echo json_encode(["erro" => "Dados incompletos enviados"]);
    exit;
}


?>
