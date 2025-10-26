<?php
require '../conecta_bd.php'; // Conexão PDO

// Receber dados do formulário via POST
$tipo_movimentacao = $_POST['tipo_movimentacao'] ?? null;
$id_usuario_siape  = $_POST['siape'] ?? null;  // identificador do usuário
$id_item           = $_POST['id_item'] ?? null;
$id_local_origem   = $_POST['id_local_origem'] ?? null;
$id_local_destino  = $_POST['id_local_destino'] ?? null;
$observacoes       = $_POST['observacoes'] ?? null;

if (!$tipo_movimentacao || !$id_usuario_siape || !$id_item) {
    echo json_encode(['erro' => 'Tipo de movimentação, usuário (siape) e item são obrigatórios.']);
    exit;
}

try {
    // Obter o ID do usuário a partir do SIAPE
    $sqlUser = "SELECT id FROM usuarios WHERE siape = :siape LIMIT 1";
    $stmtUser = $conn->prepare($sqlUser);
    $stmtUser->execute([':siape' => $id_usuario_siape]);
    $usuario = $stmtUser->fetch(PDO::FETCH_ASSOC);

    if (!$usuario) {
        echo json_encode(['erro' => 'Usuário não encontrado para o SIAPE informado.']);
        exit;
    }

    $id_usuario = $usuario['id'];

    // Inserir a movimentação
    $sql = "INSERT INTO movimentacoes (
                id_item,
                id_usuario,
                tipo_movimentacao,
                id_local_origem,
                id_local_destino,
                data_movimentacao,
                observacoes
            ) VALUES (
                :id_item,
                :id_usuario,
                :tipo,
                :origem,
                :destino,
                NOW(),
                :observacoes
            )";

    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':id_item'      => $id_item,
        ':id_usuario'   => $id_usuario,
        ':tipo'         => $tipo_movimentacao,
        ':origem'       => $id_local_origem,
        ':destino'      => $id_local_destino,
        ':observacoes'  => $observacoes
    ]);

    echo json_encode([
        'sucesso' => 'Movimentação registrada com sucesso!',
        'id_movimentacao' => $conn->lastInsertId()
    ]);

} catch (PDOException $e) {
    echo json_encode(['erro' => 'Erro ao cadastrar movimentação: ' . $e->getMessage()]);
}
?>
