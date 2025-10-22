<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Bootstrap CSS (CDN) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="view/styles.css">
    <!-- Overrides para imagens e utilitários -->
    <link rel="stylesheet" href="view/bootstrap-overrides.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="view/js/alert-override.js"></script>
    <script src="view/js/menu-toggle.js"></script>
</head>
<body>
        <header class="d-flex align-items-center justify-content-between px-3" style="height:var(--header-height);">
                <button class="btn btn-outline-light d-md-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasMenu" aria-controls="offcanvasMenu">
                        ☰
                </button>
                <h1 class="mb-0">Entrar</h1>
        </header>

        <!-- Offcanvas menu (mobile) -->
        <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasMenu" aria-labelledby="offcanvasMenuLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasMenuLabel">Menu</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="list-unstyled">
                    <li><a href="view/home.php" class="d-block py-2">Home</a></li>
                    <li><a href="view/cadastro-lista-itens.php" class="d-block py-2">Cadastrar item</a></li>
                    <li><a href="view/localizacao.php" class="d-block py-2">Localização</a></li>
                    <li><a href="view/movimento.php" class="d-block py-2">Movimentação</a></li>
                    <li><a href="view/item.php" class="d-block py-2">Item</a></li>
                    <li><a href="view/categorias.php" class="d-block py-2">Categorias</a></li>
                    <li><a href="view/usuarios.php" class="d-block py-2">Usuários</a></li>
                    <li><a href="view/relatorios.php" class="d-block py-2">Relatórios</a></li>
                </ul>
            </div>
        </div>
    <main>
        <div class="container" style="max-width:420px; margin-top:90px;">
        <form action="controller/login.php" method="POST" id ="login-form">
            <div class="mb-3">
                <label for="username" class="form-label">Usuário</label>
                <input type="text" id="username" name="usuario" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Senha</label>
                <input type="password" id="password" name="senha" class="form-control" required>
            </div>

            <button class="btn btn-primary w-100 mb-2" type="submit">Login</button>
            <button class="btn btn-link w-100" type="button" onclick="window.location.href='view/esqueci-senha.php'">Esqueci minha senha</button>
        </form>
        </div>
    </main>
</body>

    <footer>
        <p>&copy; 2025 Inventário de Itens</p>
    </footer>
  

<!-- Adicionado: SweetAlert2 e override para alert -->
<!-- Bootstrap Bundle JS (inclui Popper) -->

</html>