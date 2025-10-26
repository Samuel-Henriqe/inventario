<?php
require "../conecta_bd.php";

if (isset($_POST["id"])) {
    $id = $_POST["id"];

    try {
        $sql = "DELETE FROM itens WHERE numero_pratrimonio = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();


        if ($stmt->rowCount() > 0) {
            echo json_encode(["sucesso" => true]);
        } else {
            echo json_encode(["erro" => "Item não encontrado ou já excluído."]);
        }
    } catch (Exception $e) {
        echo json_encode(["erro" => "Erro ao excluir: " . $e->getMessage()]);
    }
} else {
    echo json_encode(["erro" => "ID nao fornecido."]);
}
?>
