<?php
require '../controller/conecta_bd.php';

try {
    // Criar a conexão PDO (a variável $conn deve estar definida no conecta_bd.php como um PDO)
    // Exemplo esperado no conecta_bd.php:
    // $conn = new PDO("mysql:host=localhost;dbname=nome_do_banco", "usuario", "senha");
    // $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Consulta SQL
    $sql = "SELECT * FROM item join localizacao on item.id_localizacao = localizacao.id_localizacao" .
           " join categoria on item.id_categoria = categoria.id_categoria";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    // Obter os resultados como array associativo
    $item = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Retornar os resultados como JSON

} catch (PDOException $e) {
    // Em caso de erro na conexão ou consulta
    echo json_encode(["erro" => "Erro na conexão ou consulta: " . $e->getMessage()]);
}

