<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS (CDN) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <!-- Overrides para imagens e utilitários -->
    <link rel="stylesheet" href="bootstrap-overrides.css">
    <title>Esqueci minha senha</title>
</head>
<body>
    <header>
        <h1>Recuperar Senha</h1>
    </header>
    <main>
        <div class="container" style="max-width:520px; margin-top:90px;">
            <form action="../controller/update/update_senha_usuario.php" method="POST" id="forgot-password-form">
                <div class="mb-3">
                    <label for="email" class="form-label">Digite seu e-mail</label>
                    <input type="email" id="email" name="email" class="form-control" required>
                </div>
                <button class="btn btn-primary" id="enviar-btn" type="submit">Enviar</button>
            </form>
        </div>
    </main>
    <!-- Bootstrap Bundle JS (inclui Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
<br><br><br>
    <footer>
        <p>&copy; 2025 Inventário de Itens</p>
    </footer>
</html>