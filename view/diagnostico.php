<?php
// Diagnóstico completo do ambiente PHP/Apache
echo "<h1>🔍 Diagnóstico Completo do Sistema</h1>";
echo "<hr>";

echo "<h2>📊 Informações do PHP</h2>";
echo "<strong>Versão PHP:</strong> " . phpversion() . "<br>";
echo "<strong>Data/Hora:</strong> " . date('d/m/Y H:i:s') . "<br>";
echo "<strong>Sistema Operacional:</strong> " . php_uname() . "<br>";
echo "<strong>Servidor:</strong> " . $_SERVER['SERVER_SOFTWARE'] . "<br>";
echo "<strong>Document Root:</strong> " . $_SERVER['DOCUMENT_ROOT'] . "<br>";
echo "<strong>Script atual:</strong> " . __FILE__ . "<br>";
echo "<hr>";

echo "<h2>🌐 Informações da Requisição</h2>";
echo "<strong>HOST:</strong> " . $_SERVER['HTTP_HOST'] . "<br>";
echo "<strong>REQUEST_URI:</strong> " . $_SERVER['REQUEST_URI'] . "<br>";
echo "<strong>SERVER_NAME:</strong> " . $_SERVER['SERVER_NAME'] . "<br>";
echo "<strong>SERVER_PORT:</strong> " . $_SERVER['SERVER_PORT'] . "<br>";
echo "<strong>REMOTE_ADDR:</strong> " . $_SERVER['REMOTE_ADDR'] . "<br>";
echo "<hr>";

echo "<h2>📁 Verificação de Arquivos</h2>";
$arquivos_teste = [
    'cadastro-lista-itens.php',
    'localizacao.php', 
    'home.php',
    'styles.css',
    '../index.php'
];

foreach($arquivos_teste as $arquivo) {
    $caminho = __DIR__ . '/' . $arquivo;
    if(file_exists($caminho)) {
        echo "✅ <strong>$arquivo:</strong> EXISTS (" . filesize($caminho) . " bytes)<br>";
    } else {
        echo "❌ <strong>$arquivo:</strong> NOT FOUND<br>";
    }
}
echo "<hr>";

echo "<h2>🔌 Teste de Conexão com Banco</h2>";
try {
    require_once '../controller/conecta_bd.php';
    echo "✅ <strong>Conexão BD:</strong> SUCESSO<br>";
    
    // Testar consulta simples
    $stmt = $conn->query("SELECT 1 as teste");
    $result = $stmt->fetch();
    echo "✅ <strong>Consulta teste:</strong> " . $result['teste'] . "<br>";
    
} catch(Exception $e) {
    echo "❌ <strong>Erro BD:</strong> " . $e->getMessage() . "<br>";
}
echo "<hr>";

echo "<h2>🔧 Extensões PHP Importantes</h2>";
$extensoes = ['pdo', 'pdo_mysql', 'mysqli', 'json', 'mbstring', 'openssl'];
foreach($extensoes as $ext) {
    if(extension_loaded($ext)) {
        echo "✅ <strong>$ext:</strong> CARREGADA<br>";
    } else {
        echo "❌ <strong>$ext:</strong> NÃO ENCONTRADA<br>";
    }
}
echo "<hr>";

echo "<h2>📋 Variáveis de Ambiente</h2>";
echo "<strong>PATH:</strong> " . (isset($_SERVER['PATH']) ? substr($_SERVER['PATH'], 0, 200) . "..." : "Não definida") . "<br>";
echo "<strong>TEMP:</strong> " . (isset($_SERVER['TEMP']) ? $_SERVER['TEMP'] : "Não definida") . "<br>";

echo "<h2>🎯 URLs de Teste</h2>";
$base_url = "http://" . $_SERVER['HTTP_HOST'] . "/inventario/view/";
echo "<a href='{$base_url}cadastro-lista-itens.php' target='_blank'>📝 Cadastro Lista Itens</a><br>";
echo "<a href='{$base_url}localizacao.php' target='_blank'>📍 Localização</a><br>";
echo "<a href='{$base_url}home.php' target='_blank'>🏠 Home</a><br>";

echo "<hr>";
echo "<p><small>Gerado em: " . date('d/m/Y H:i:s') . "</small></p>";
?>