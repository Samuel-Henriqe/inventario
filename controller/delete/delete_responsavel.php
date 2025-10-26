<?php
require "../conecta_bd.php";

if (isset($_POST["id_responsavel"])) {
    $id = $_POST["id_resposavel"];

    try {
        $sql = "DELETE FROM responsavel WHERE id_responsavel = :id_responsavel";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":id_responsavel", $id, PDO::PARAM_INT);
        $stmt->execute();


        if ($stmt->rowCount() > 0) {
            echo json_encode(["sucesso" => true]);
        } else {
            echo json_encode(["erro" => "responsavel não encontrado ou já excluído."]);
        }
    } catch (Exception $e) {
        echo json_encode(["erro" => "Erro ao excluir: " . $e->getMessage()]);
    }
} else {
    echo json_encode(["erro" => "ID nao fornecido."]);
}
?>
