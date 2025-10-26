<?php
require "../conecta_bd.php"; // Conexão PDO em $conn

// Verifica se os dados foram enviados
if (isset($_POST["siape"], $_POST["nome"], $_POST["email"], $_POST["senha"])) {

    // Sanitiza e coleta os dados
    $siape = trim($_POST["siape"]);
    $nome = trim($_POST["nome"]);
    $email = trim($_POST["email"]);
    $senha = $_POST["senha"];
    $tipo = $_POST["tipo"] ?? 'usuario'; // padrão
    $ativo = 1;

    try {
        // Gerar hash seguro da senha
        $hash = password_hash($senha, PASSWORD_DEFAULT);

        // Inserir usuário
        $sql = "INSERT INTO usuarios (siape, nome, email, senha, tipo, ativo)
                VALUES (:siape, :nome, :email, :senha, :tipo, :ativo)";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':siape', $siape);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':senha', $hash);
        $stmt->bindParam(':tipo', $tipo);
        $stmt->bindParam(':ativo', $ativo, PDO::PARAM_INT);

        $stmt->execute();

        echo json_encode(["sucesso" => true, "mensagem" => "Usuário inserido com sucesso!"]);

    } catch (PDOException $e) {
        // Tratamento para erro de duplicidade (email ou siape já existente)
        if ($e->getCode() == 23000) {
            echo json_encode(["erro" => "SIAPE ou e-mail já cadastrados."]);
        } else {
            echo json_encode(["erro" => "Erro ao inserir usuário: " . $e->getMessage()]);
        }
    }

} else {
    echo json_encode(["erro" => "Dados incompletos enviados"]);
    exit;
}
?>
