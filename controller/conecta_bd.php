<?php
// Conectar ao banco de dados MySQL
$host= "sql103.infinityfree.com";
$db = "if0_40140536_db_inventario";
$user = "if0_40140536";
$pass = "Sam09060024";

try {
    $conn = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro na conexão: " . $e->getMessage());
}
?>