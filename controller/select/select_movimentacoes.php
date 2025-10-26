<?php
require '../../conecta_bd.php';

try {
    // Consulta SQL com JOINs para buscar informações da movimentação e do item
    $sql = "
        SELECT 
            movimentacoes.id_item AS id_item,
            itens.nome AS nome_item,
            movimentacoes.data_movimentacao AS data_movimentacao,
            usuarios.nome as nome_usuario,
            movimentacoes.tipo_movimentacao AS tipo_movimentacao
        FROM 
            movimentacoes
        JOIN 
            itens ON movimentacoes.id_item = itens.id
        JOIN
            usuarios ON movimentacoes.id_usuario = usuarios.id
        ORDER BY
            movimentacoes.data_movimentacao DESC
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
