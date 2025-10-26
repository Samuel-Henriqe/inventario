<?php
require "../conecta_bd.php";

if (isset($_POST["id_categoria"])) {
    $id = $_POST["id_categoria"];

    try {
        $sql = "DELETE FROM categorias WHERE id = :id_categorias";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();


        if ($stmt->rowCount() > 0) {
            echo json_encode(["sucesso" => true]);
        } else {
            echo json_encode(["erro" => "categoria não encontrado ou já excluído."]);
        }
    } catch (Exception $e) {
        echo json_encode(["erro" => "Erro ao excluir: " . $e->getMessage()]);
    }
} else {
    echo json_encode(["erro" => "ID nao fornecido."]);
}
?>
