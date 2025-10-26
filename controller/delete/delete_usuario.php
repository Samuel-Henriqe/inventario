<?php
require "../conecta_bd.php";

if (isset($_POST["siape"])) {
    $siape = $_POST["siape"];

    try {
        $sql = "DELETE FROM usuario WHERE siape = :siape";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            echo json_encode(["sucesso" => true]);
        } else {
            echo json_encode(["erro" => "usuario não encontrado ou já excluído."]);
        }
    } catch (Exception $e) {
        echo json_encode(["erro" => "Erro ao excluir: " . $e->getMessage()]);
    }
} else {
    echo json_encode(["erro" => "ID nao fornecido."]);
}
?>
