<?php 
require_once __DIR__ . '../controller/conecta_bd.php'; // ajuste caminho se necessário

$numero = $_GET['numero'] ?? '';
if (!$numero) {
    http_response_code(400);
    echo "Número faltando";
    exit;
}

// Busque o item pelo número de tombamento (use prepared statements)
$sql = "SELECT nome_item, numero_tombamento, descricao_item, unidade_de_medida, status_item, data_aquisicao, nome_local, nome_categoria
        FROM itens
        LEFT JOIN localizacoes ON itens.id_localizacao = localizacoes.id
        LEFT JOIN categorias ON itens.id_categoria = categorias.id
        WHERE numero_tombamento = :numero_tombamento LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':numero_tombamento', $numero );
$stmt->execute();
$item = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$item) {
    echo "Item não encontrado";
    exit;
}
?>
<!doctype html>
<html lang="pt-BR">
<head>
<meta charset="utf-8">
<title>Etiqueta - <?php echo htmlspecialchars($item['numero_tombamento']); ?></title>
</head>
<body>
<h1>Item <?php echo htmlspecialchars($item['numero_tombamento']); ?></h1>

<pre><?php
echo "Número: " . htmlspecialchars($item['numero_tombamento']) . "\n";
echo "Nome: " . htmlspecialchars($item['nome_item']) . "\n";
echo "Descrição: " . htmlspecialchars($item['descricao_item']) . "\n";
echo "Unidade: " . htmlspecialchars($item['unidade_de_medida']) . "\n";
echo "Status: " . htmlspecialchars($item['status_item']) . "\n";
echo "Data de aquisição: " . htmlspecialchars($item['data_aquisicao']) . "\n";
echo "Localização: " . htmlspecialchars($item['nome_local']) . "\n";
echo "Categoria: " . htmlspecialchars($item['nome_categoria']) . "\n";
?>
</pre>
</body>
</html>