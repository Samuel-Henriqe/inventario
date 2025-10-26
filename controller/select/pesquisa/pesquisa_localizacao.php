<?php
require '../../conecta_bd.php';

if (
    isset($_POST["id_localizacao"], $_POST["nome_local"], $_POST["descricao_local"], $_POST["id_responsavel"])
    && 
    (
        $_POST["id_localizacao"] != null || $_POST["nome_local"] != null || 
        $_POST["descricao_local"] != null || $_POST["id_responsavel"] != null 
    )
) {
    $id_localizacao = $_POST["id_localizacao"];
    $nome_local = $_POST["nome_local"];
    $descricao_local = $_POST["descricao_local"];
    $id_responsavel = $_POST["id_responsavel"];

    try {
        $sql = "SELECT nome_local, descricao_local
                FROM localizacao 
                JOIN responsavel on localizacao.id_responsavel = responsvel.id_repo
                WHERE 
                    (:id_localizacao IS NULL OR :id_localizacao = '' OR id_localizacao LIKE :id_localizacao) AND
                    (:nome_local IS NULL OR :nome_local = '' OR nome_local LIKE :nome_local) AND
                    (:descricao_local IS NULL OR :descricao_local = '' OR descricao_local LIKE :descricao_local) AND
                    (:id_responsavel IS NULL OR :id_resposavel = '' OR item.id_resposavel LIKE :id_resposavel)";
        $stmt = $conn->prepare($sql);

        // Parâmetros com LIKE e %
        $stmt->bindValue(':id_localizacao', $id_localizacao !== '' ? '%' . $id_localizacao . '%' : null);
        $stmt->bindValue(':nome_local', $nome_local !== '' ? '%' . $nome_local . '%' : null);
        $stmt->bindValue(':descricao_local', $descricao_local !== '' ? '%' . $descricao_local . '%' : null);
        $stmt->bindValue(':responsavel', $responsavel !== '' ? '%' . $responsavel . '%' : null);

        $stmt->execute();

        $localizacao = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($localizacao);

    } catch (PDOException $e) {
        echo json_encode(["erro" => "Erro na conexão ou consulta: " . $e->getMessage()]);
    }
} else {
    echo json_encode(["erro" => "Dados incompletos"]);
}
?>
