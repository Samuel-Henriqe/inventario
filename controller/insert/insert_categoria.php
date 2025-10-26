<?php
require "../conecta_bd.php"; // Conexão PDO em $conn

// Verifica se os dados foram enviados corretamente
if (isset($_POST["nome_categoria"], $_POST["descricao_categoria"])) {
    // Coleta os valores do formulário
    $nome_categoria = trim($_POST["nome_categoria"]);
    $descricao_categoria = trim($_POST["descricao_categoria"]);

    try {
        // Inserir categoria na tabela "categorias"
        $sql = "INSERT INTO categorias (nome, descricao)
                VALUES (:nome, :descricao)";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':nome', $nome_categoria);
        $stmt->bindParam(':descricao', $descricao_categoria);

        $stmt->execute();

        echo json_encode([
            "sucesso" => true,
            "mensagem" => "Categoria inserida com sucesso!"
        ]);
    } catch (Exception $e) {
        echo json_encode(["erro" => "Erro ao inserir categoria: " . $e->getMessage()]);
    }
} else {
    echo json_encode(["erro" => "Dados incompletos enviados"]);
    exit;
}
?>
