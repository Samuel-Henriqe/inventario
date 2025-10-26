<?php
header('Content-Type: application/json');
require '../conecta_bd.php';

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
    $localizacoes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Retornar os dados em formato JSON
    echo json_encode($localizacoes);

} catch (PDOException $e) {
    // Em caso de erro na conexão ou consulta
    echo json_encode(["erro" => "Erro na conexão ou consulta: " . $e->getMessage()]);
}
?>
