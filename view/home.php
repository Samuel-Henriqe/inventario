<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <!-- Bootstrap CSS (CDN) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <!-- Overrides para imagens e utilitários (carregado após o styles.css) -->
    <link rel="stylesheet" href="bootstrap-overrides.css">
        <!-- Bootstrap Bundle JS (inclui Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<header class="d-flex align-items-center justify-content-between px-3" style="height:var(--header-height);">
        <div>
            <button class="btn btn-outline-light d-md-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasMenu" aria-controls="offcanvasMenu">☰</button>
            <button class="btn btn-outline-light d-none d-md-inline-block menu-toggle ms-2" title="Abrir/Fechar menu">☰</button>
        </div>
        <h1 class="mb-0">Bem-vindo ao Sistema de Inventário</h1>
</header>

<!-- Offcanvas menu (mobile) -->
<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasMenu" aria-labelledby="offcanvasMenuLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasMenuLabel">Menu</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <ul class="list-unstyled">
            <li><a href="home.php" class="d-block py-2">Home</a></li>
            <li><a href="cadastro-lista-itens.php" class="d-block py-2">Cadastrar item</a></li>
            <li><a href="localizacao.php" class="d-block py-2">Localização</a></li>
            <li><a href="movimento.php" class="d-block py-2">Movimentação</a></li>
            <li><a href="item.php" class="d-block py-2">Item</a></li>
            <li><a href="categorias.php" class="d-block py-2">Categorias</a></li>
            <li><a href="usuarios.php" class="d-block py-2">Usuários</a></li>
            <li><a href="relatorios.php" class="d-block py-2">Relatórios</a></li>
        </ul>
    </div>
</div>
<br><br><br>
<body>
      <p id="info">Utilize o menu para navegar pelas funcionalidades do sistema.</p>
<div id="home" class="container" style="margin-top:60px;">
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3 justify-content-center">
        <div class="col text-center">
            <a href="cadastro-lista-itens.php" class="btn btn-success btn-lg w-100 py-4">Cadastrar item</a>
        </div>
        <div class="col text-center">
            <a href="localizacao.php" class="btn btn-success btn-lg w-100 py-4">Localização</a>
        </div>
        <div class="col text-center">
            <a href="movimento.php" class="btn btn-success btn-lg w-100 py-4">Movimentação</a>
        </div>
        <div class="col text-center">
            <a href="item.php" class="btn btn-success btn-lg w-100 py-4">Item</a>
        </div>
        <div class="col text-center">
            <a href="categorias.php" class="btn btn-success btn-lg w-100 py-4">Categorias</a>
        </div>
        <div class="col text-center">
            <a href="usuarios.php" class="btn btn-success btn-lg w-100 py-4">Usuários</a>
        </div>
        <div class="col text-center">
            <a href="relatorios.php" class="btn btn-success btn-lg w-100 py-4">Relatórios</a>
        </div>
        <div class="col text-center">
            <a href="../index.php" class="btn btn-outline-secondary btn-lg w-100 py-4">Sair</a>
        </div>
    </div>

    <!-- Menu toggle script -->
    <script src="js/menu-toggle.js"></script>

</body>
<br><br><br>

    <footer>
        <p>&copy; 2025 Inventário de Itens</p>
    </footer>
</html>