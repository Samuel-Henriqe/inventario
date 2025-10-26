<?php
require '../controller/conecta_bd.php';

if (isset($_POST["id_local"])) {
    $id_local = $_POST["id_local"];

    try {
        $sql = "DELETE FROM localizacoes WHERE id = :id_local";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":id_local", $id_local, PDO::PARAM_INT);
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
