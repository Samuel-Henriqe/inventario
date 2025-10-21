<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
 
</head>
<body>
    <header>
        <h1>Entrar</h1>
    </header>
    <main>
        <form action="../controller/login.php" method="POST" id="login-form">
            <label for="username">Usuário:</label>
            <input type="text"  name="usuario" required>

            <label for="password">Senha:</label>
            <input type="text" name="senha" required>

            <button type="submit">Login</button>            
        </form>


    </main>
</body>
    <footer>
        <p>&copy; 2025 Inventário de Itens</p>
    </footer>
</html>