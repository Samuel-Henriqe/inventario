<?php
require '../controller/conecta_bd.php';

try {
    // Consulta SQL com JOINs para buscar nomes no lugar dos IDs
    $sql = "
        SELECT 
            itens.nome AS nome_item,
            itens.numero_patrimonio AS numero_patrimonio,
            itens.descricao AS descricao,
            itens.status AS status,
            itens.observacoes AS observacoes,
            itens.data_aquisicao AS data_aquisicao,
            localizacoes.nome AS id_localizacao,
            categorias.nome AS id_categoria
        FROM 
            itens
        JOIN 
            localizacoes ON itens.id_localizacao = localizacoes.id
        JOIN
            categorias ON itens.id_categoria = categorias.id
    ";

    $stmt = $conn->prepare($sql);
    $stmt->execute();

    // Obter os resultados como array associativo
    $item = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Retornar os dados em formato JSON
    // echo json_encode($item);

} catch (PDOException $e) {
    // Em caso de erro na conexão ou consulta
    echo json_encode(["erro" => "Erro na conexão ou consulta: " . $e->getMessage()]);
}
?>