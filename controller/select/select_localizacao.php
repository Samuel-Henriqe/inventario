<?php
require '../controller/conecta_bd.php';

try {
    // Criar a conexão PDO (a variável $conn deve estar definida no conecta_bd.php como um PDO)
    // Exemplo esperado no conecta_bd.php:
    // $conn = new PDO("mysql:host=localhost;dbname=nome_do_banco", "usuario", "senha");
    // $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Consulta SQL
    $sql = "SELECT * FROM localizacoes";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    // Obter os resultados como array associativo
    $localizacao = $stmt->fetchAll(PDO::FETCH_ASSOC);



} catch (PDOException $e) {
    // Em caso de erro na conexão ou consulta
    echo json_encode(["erro" => "Erro na conexão ou consulta: " . $e->getMessage()]);
}
?>
