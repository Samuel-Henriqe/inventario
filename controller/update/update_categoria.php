<?php
require "../conecta_bd.php"; // Conexão PDO deve estar em $conn

// Verifica se todos os dados necessários foram enviados
if (isset($_POST["id_categoria"], $_POST["nome_categoria"], $_POST["descricao_categoria"])) {

    // Sanitização básica
    $id_categoria = trim($_POST["id_categoria"]);
    $nome_categoria = trim($_POST["nome_categoria"]);
    $descricao_categoria = trim($_POST["descricao_categoria"]);

    try {
        // Verifica se a categoria existe antes de atualizar
        $verifica = $conn->prepare("SELECT id FROM categorias WHERE id = :id");
        $verifica->bindParam(':id', $id_categoria, PDO::PARAM_INT);
        $verifica->execute();

        if ($verifica->rowCount() === 0) {
            echo json_encode(["erro" => "Categoria não encontrada."]);
            exit;
        }

        // Atualiza os campos enviados (mantém antigos se vierem vazios)
        $sql = "UPDATE categorias SET 
                    nome = COALESCE(NULLIF(:nome, ''), nome),
                    descricao = COALESCE(NULLIF(:descricao, ''), descricao)
                WHERE id = :id";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':nome', $nome_categoria);
        $stmt->bindParam(':descricao', $descricao_categoria);
        $stmt->bindParam(':id', $id_categoria, PDO::PARAM_INT);

        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            echo json_encode(["sucesso" => true, "mensagem" => "Categoria atualizada com sucesso!"]);
        } else {
            echo json_encode(["aviso" => "Nenhuma alteração detectada."]);
        }

    } catch (PDOException $e) {
        echo json_encode(["erro" => "Erro ao atualizar categoria: " . $e->getMessage()]);
    }

} else {
    echo json_encode(["erro" => "Dados incompletos enviados."]);
}
?>
