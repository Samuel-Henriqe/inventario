<?php

require "../conecta_bd.php"; // já cria $conn (PDO)
// api.php
// Endpoint único para relatórios do inventário - retorna JSON
// Exemplo: api.php?report=estoque_atual

header('Content-Type: application/json; charset=utf-8');
ini_set('display_errors', 0);


function jsonResponse($data, int $status = 200): void {
    http_response_code($status);
    echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    exit;
}

$report = isset($_GET['report']) ? trim($_GET['report']) : null;
if (!$report) {
    jsonResponse([
        'error' => 'Parâmetro "report" é obrigatório.',
        'exemplos' => [
            'estoque_atual',
            'historico_movimentacoes',
            'itens_sem_movimentacao',
            'movimentacao_por_usuario',
            'resumo_movimentacoes',
            'saldo_por_localizacao',
            'item'
        ]
    ], 400);
}

// Função para ler parâmetros de filtro com fallback
function param(string $name, $default = null) {
    return isset($_GET[$name]) && $_GET[$name] !== '' ? $_GET[$name] : $default;
}

// Paginação simples
$limit  = max(1, (int)param('limit', 100));
$page   = max(1, (int)param('page', 1));
$offset = ($page - 1) * $limit;

try {
    switch ($report) {
        case 'estoque_atual':
        case 'historico_movimentacoes':
        case 'itens_sem_movimentacao':
        case 'movimentacao_por_usuario':
        case 'resumo_movimentacoes':
        case 'saldo_por_localizacao':
        case 'item':
            require __DIR__ . "/$report.php";
            break;

        default:
            jsonResponse(['error' => "Relatório desconhecido: $report"], 400);
    }
} catch (PDOException $e) {
    jsonResponse(['error' => 'Erro na consulta SQL', 'detail' => $e->getMessage()], 500);
} catch (Exception $e) {
    jsonResponse(['error' => 'Erro interno', 'detail' => $e->getMessage()], 500);
}
