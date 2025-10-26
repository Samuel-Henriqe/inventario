<?php
require '../../conecta_bd.php';

if (
    isset($_POST["numero_tombamento"], $_POST["nome_item"], $_POST["descricao_item"],
          $_POST["unidade_de_medida"], $_POST["status_item"], $_POST["data_aquisicao"],
          $_POST["id_local"], $_POST["id_categoria"]) && 
    (
        $_POST["numero_tombamento"] != null || $_POST["nome_item"] != null || $_POST["descricao_item"] != null ||
        $_POST["unidade_de_medida"] != null || $_POST["status_item"] != null || $_POST["data_aquisicao"] != null ||
        $_POST["id_local"] != null || $_POST["id_categoria"] != null
    )
) {
    $numero_tombamento = $_POST["numero_tombamento"];
    $nome_item = $_POST["nome_item"];
    $descricao_item = $_POST["descricao_item"];
    $unidade_de_medida = $_POST["unidade_de_medida"];
    $status_item = $_POST["status_item"];
    $data_aquisicao = $_POST["data_aquisicao"];
    $id_localizacao = $_POST["id_local"];
    $id_categoria = $_POST["id_categoria"];

    try {
        $sql = "SELECT item.numero_tombamento,
                       item.nome_item, 
                       item.descricao_item,
                       item.unidade_de_medida, 
                       item.status_item, 
                       item.data_aquisicao, 
                       localizacao.nome_local AS nome_localizacao,
                       categoria.nome_categoria AS nome_categoria
                FROM item
                JOIN localizacao ON item.id_localizacao = localizacao.id_localizacao
                JOIN categoria ON item.id_categoria = categoria.id_categoria
                WHERE 
                    (:numero_tombamento IS NULL OR :numero_tombamento = '' OR item.numero_tombamento LIKE :numero_tombamento) AND
                    (:nome_item IS NULL OR :nome_item = '' OR item.nome_item LIKE :nome_item) AND
                    (:descricao_item IS NULL OR :descricao_item = '' OR item.descricao_item LIKE :descricao_item) AND
                    (:unidade_de_medida IS NULL OR :unidade_de_medida = '' OR item.unidade_de_medida LIKE :unidade_de_medida) AND
                    (:status_item IS NULL OR :status_item = '' OR item.status_item LIKE :status_item) AND
                    (:data_aquisicao IS NULL OR :data_aquisicao = '' OR item.data_aquisicao LIKE :data_aquisicao) AND
                    (:id_localizacao IS NULL OR :id_localizacao = '' OR item.id_localizacao LIKE :id_localizacao) AND
                    (:id_categoria IS NULL OR :id_categoria = '' OR item.id_categoria LIKE :id_categoria)";

        $stmt = $conn->prepare($sql);

        // Parâmetros com LIKE e %
        $stmt->bindValue(':numero_tombamento', $numero_tombamento !== '' ? '%' . $numero_tombamento . '%' : null);
        $stmt->bindValue(':nome_item', $nome_item !== '' ? '%' . $nome_item . '%' : null);
        $stmt->bindValue(':descricao_item', $descricao_item !== '' ? '%' . $descricao_item . '%' : null);
        $stmt->bindValue(':unidade_de_medida', $unidade_de_medida !== '' ? '%' . $unidade_de_medida . '%' : null);
        $stmt->bindValue(':status_item', $status_item !== '' ? '%' . $status_item . '%' : null);
        $stmt->bindValue(':data_aquisicao', $data_aquisicao !== '' ? '%' . $data_aquisicao . '%' : null);
        $stmt->bindValue(':id_localizacao', $id_localizacao !== '' ? '%' . $id_localizacao . '%' : null);
        $stmt->bindValue(':id_categoria', $id_categoria !== '' ? '%' . $id_categoria . '%' : null);

        $stmt->execute();

        $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($items);

    } catch (PDOException $e) {
        echo json_encode(["erro" => "Erro na conexão ou consulta: " . $e->getMessage()]);
    }
} else {
    echo json_encode(["erro" => "Dados incompletos"]);
}
?>
