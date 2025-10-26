<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <!-- ===== CONFIGURAÇÕES BÁSICAS DO DOCUMENTO ===== -->
    <!-- Metadados essenciais para renderização correta e responsividade -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movimentação - Sistema de Inventário</title>
    
    <!-- ===== FOLHAS DE ESTILO (CSS) ===== -->
    <!-- Bootstrap CSS Framework via CDN para componentes responsivos -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Estilos personalizados do projeto (variáveis CSS, header, footer) -->
    <link rel="stylesheet" href="styles.css">
    
    <!-- Overrides especializados para imagens responsivas e utilitários -->
    <link rel="stylesheet" href="bootstrap-overrides.css">
</head>

<body>
    <!-- ===== CABEÇALHO RESPONSIVO ===== -->
    <!-- Header com navegação e título da página de movimentação -->
    <header class="d-flex align-items-center justify-content-between px-3" style="height:var(--header-height);">
        <div>
            <!-- Botão de menu para dispositivos móveis (visível em telas pequenas) -->
            <button class="btn btn-outline-light d-md-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasMenu" aria-controls="offcanvasMenu">☰</button>
            
            <!-- Botão de menu para desktop (visível apenas em telas médias e grandes) -->
            <button class="btn btn-outline-light d-none d-md-inline-block menu-toggle ms-2" title="Abrir/Fechar menu">☰</button>
        </div>
        
        <!-- Título principal da página -->
        <h1 class="mb-0">Movimentação de Itens</h1>
        
        <!-- Botão de navegação para voltar à página inicial -->
        <a href="home.php" class="btn btn-outline-light">← Voltar</a>
    </header>

    <!-- ===== CONTEÚDO PRINCIPAL ===== -->
    <!-- Container centralizado com espaçamento superior -->
    <div class="container mt-4">
        
        <!-- ===== ALERTA DE DESENVOLVIMENTO ===== -->
        <!-- Notificação informativa sobre o status da funcionalidade -->
        <div class="alert alert-info">
            <h4>Página em Desenvolvimento</h4>
            <p>Esta funcionalidade está sendo desenvolvida. Em breve você poderá gerenciar a movimentação de itens do inventário.</p>
        </div>
    </div>

    <!-- ===== SCRIPTS JAVASCRIPT ===== -->
    <!-- Bootstrap Bundle JS com Popper.js incluído para funcionalidades interativas -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Script para controle responsivo do menu lateral -->
    <script src="js/menu-toggle.js"></script>

</body>
</html>