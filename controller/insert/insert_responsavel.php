<?php
require "../conecta_bd.php"; // Aqui deve conter a conexão PDO em $conn

if (
    isset($_POST["nome_responsavel"])
) {
    // Agora sim: podemos acessar os valores com segurança
    $nome_responsavel = $_POST["nome_responsavel"];
    

    // ... continua com o restante do seu código
    try {
    

    // Inserir item
    $sql = "INSERT INTO responsavel (
        nome_resposavel
    ) VALUES (
        :nome_responsavel
    )";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':nome_responsavel', $nome_responsavel);

    $stmt->execute();

    echo json_encode(["sucesso" => true, "mensagem" => "responsavel inserido com sucesso"]);

} catch (Exception $e) {
    echo json_encode(["erro" => $e->getMessage()]);
}
}
else {
    echo json_encode(["erro" => "Dados incompletos enviados"]);
    exit;
}


?>
