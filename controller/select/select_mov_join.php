<?php
require '../../conecta_bd.php';

try {
    // Consulta SQL com JOINs para buscar informações da movimentação e do item
    $sql = "
        SELECT 
            movimentacao_item.id_item AS id_item,
            item.nome_item AS nome_item,
            movimentacao.data_movimentacao AS data_movimentacao,
            movimentacao.tipo_movimentacao AS tipo_movimentacao,
            movimentacao_item.quantidade AS quantidade
        FROM 
            movimentacao_item
        JOIN 
            item ON movimentacao_item.id_item = item.id_item
        JOIN
            movimentacao ON movimentacao_item.id_movimentacao = movimentacao.id_movimentacao
        ORDER BY
            movimentacao.data_movimentacao DESC
    ";

    $stmt = $conn->prepare($sql);
    $stmt->execute();

    // Obter os resultados como array associativo
    $movimentacoes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Retornar os dados em formato JSON
    echo json_encode($movimentacoes);

} catch (PDOException $e) {
    // Em caso de erro na conexão ou consulta
    echo json_encode(["erro" => "Erro na conexão ou consulta: " . $e->getMessage()]);
}
?>
