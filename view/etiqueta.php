<?php 
    // ===== GERAÇÃO DE ETIQUETA PARA IMPRESSÃO =====
    // Este arquivo gera uma página simplificada para impressão de etiquetas com dados do item
    // Recebe o número de tombamento via GET e exibe informações formatadas do item
    
    // ===== CONEXÃO COM BANCO DE DADOS =====
    // Inclui o arquivo de conexão com o banco de dados
    require_once __DIR__ . '../controller/conecta_bd.php';

    // ===== VALIDAÇÃO DE PARÂMETROS =====
    // Recebe o número de tombamento via parâmetro GET
    $numero = $_GET['numero'] ?? '';
    
    // Verifica se o parâmetro número foi fornecido
    if (!$numero) {
        http_response_code(400);
        echo "Número faltando";
        exit;
    }

    // ===== CONSULTA SQL SEGURA =====
    // Busca o item pelo número de tombamento usando prepared statements para segurança
    $sql = "SELECT nome_item, numero_tombamento, descricao_item, unidade_de_medida, status_item, data_aquisicao, nome_local, nome_categoria
            FROM itens
            LEFT JOIN localizacoes ON itens.id_localizacao = localizacoes.id
            LEFT JOIN categorias ON itens.id_categoria = categorias.id
            WHERE numero_tombamento = :numero_tombamento LIMIT 1";
    
    // Prepara e executa a consulta de forma segura
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':numero_tombamento', $numero);
    $stmt->execute();
    $item = $stmt->fetch(PDO::FETCH_ASSOC);

    // ===== VALIDAÇÃO DE RESULTADO =====
    // Verifica se o item foi encontrado no banco de dados
    if (!$item) {
        echo "Item não encontrado";
        exit;
    }
?>
<!doctype html>
<html lang="pt-BR">

<head>
    <!-- ===== CONFIGURAÇÕES BÁSICAS PARA IMPRESSÃO ===== -->
    <!-- Metadados otimizados para geração de etiqueta impressa -->
    <meta charset="utf-8">
    <title>Etiqueta - <?php echo htmlspecialchars($item['numero_tombamento']); ?></title>
</head>

<body>
    <!-- ===== CABEÇALHO DA ETIQUETA ===== -->
    <!-- Título principal da etiqueta com número de tombamento -->
    <h1>Item <?php echo htmlspecialchars($item['numero_tombamento']); ?></h1>

    <!-- ===== DADOS DO ITEM PARA IMPRESSÃO ===== -->
    <!-- Formatação em texto pré-formatado para impressão limpa -->
    <pre><?php
        // ===== EXIBIÇÃO FORMATADA DOS DADOS =====
        // Cada campo do item é exibido com escape de caracteres especiais
        echo "Número: " . htmlspecialchars($item['numero_tombamento']) . "\n";
        echo "Nome: " . htmlspecialchars($item['nome_item']) . "\n";
        echo "Descrição: " . htmlspecialchars($item['descricao_item']) . "\n";
        echo "Unidade: " . htmlspecialchars($item['unidade_de_medida']) . "\n";
        echo "Status: " . htmlspecialchars($item['status_item']) . "\n";
        echo "Data de aquisição: " . htmlspecialchars($item['data_aquisicao']) . "\n";
        echo "Localização: " . htmlspecialchars($item['nome_local']) . "\n";
        echo "Categoria: " . htmlspecialchars($item['nome_categoria']) . "\n";
    ?></pre>

</body>
</html>