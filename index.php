<!DOCTYPE html>
<html lang="pt-BR">

<!-- ========================================
     CABEÇALHO DO DOCUMENTO HTML
     ========================================
     Define metadados, título e carrega recursos externos
-->
    <head>
        <!-- Configurações básicas do documento -->
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login - Sistema de Inventário</title>
        
        <!-- FOLHAS DE ESTILO (CSS) -->
        <!-- Bootstrap CSS: Framework CSS para responsividade e componentes -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        
        <!-- Estilos personalizados: cores do projeto, header fixo, footer -->
        <link rel="stylesheet" href="view/styles.css">
        
        <!-- Overrides específicos: utilitários para imagens, QR codes e offcanvas -->
        <link rel="stylesheet" href="view/bootstrap-overrides.css">
        

        
        <!-- SweetAlert2: biblioteca para alertas bonitos e interativos -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        
        <!-- Script personalizado: substitui alert() padrão por SweetAlert2 -->
        <script src="view/js/alert-override.js"></script>
    </head>

    <!-- ========================================
        CORPO DA PÁGINA
        ========================================
        Estrutura visual principal da página de login
    -->
    <body>
        <!-- CABEÇALHO FIXO -->
        <!-- Header com altura fixa definida em --header-height (66px) -->
        <!-- Usa classes Bootstrap para layout flexível e espaçamento -->
        <header class="d-flex align-items-center justify-content-between px-3" 
                style="height:var(--header-height);">
            <h1 class="mb-0">Entrar</h1>
        </header>

        <!-- CONTEÚDO PRINCIPAL -->
        <!-- Container Bootstrap limitado a 420px para formulário compacto -->
        <!-- margin-top compensa a altura do header fixo -->
        <main>
            <div class="container" style="max-width:420px; margin-top:90px;">
                
                <!-- SISTEMA DE ALERTAS DE ERRO -->
                <!-- PHP: verifica se há mensagens de erro na sessão -->
                <!-- Exibe alertas Bootstrap dismissíveis para feedback ao usuário -->
            <?php
                session_start();
                if (isset($_SESSION['erro_login'])) {
                    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
                    echo htmlspecialchars($_SESSION['erro_login']); // Sanitiza saída para segurança
                    echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                    echo '</div>';
                    unset($_SESSION['erro_login']); // Remove erro após exibir
                }
            ?>
                
                <!-- FORMULÁRIO DE LOGIN -->
                <!-- Envia dados via POST para controller/login.php -->
                <!-- Bootstrap classes para estilização responsiva -->
            <form action="controller/login.php" method="POST" id="login-form">
                    
                    <!-- Campo de usuário (email) -->
                <div class="mb-3">
                    <label for="usuario" class="form-label">Usuário</label>
                    <input type="text" 
                            id="usuario" 
                            name="usuario" 
                            class="form-control" 
                            required>
                </div>

                    <!-- Campo de senha -->
                <div class="mb-3">
                    <label for="password" class="form-label">Senha</label>
                    <input type="password" 
                            id="password" 
                            name="senha" 
                            class="form-control" 
                            required>
                </div>

                    <!-- Botões de ação -->
                    <!-- Botão principal: submete o formulário -->
                    <button class="btn btn-primary w-100 mb-2" type="submit">Login</button>
                    
                    <!-- Botão secundário: redireciona para recuperação de senha -->
                    <button class="btn btn-link w-100" 
                            type="button" 
                            onclick="window.location.href='view/esqueci-senha.php'">
                            Esqueci minha senha 
                    </button>
            </form>
            </div>
        </main>

        <!-- RODAPÉ -->
        <!-- Footer simples com copyright -->
        <!-- Estilo definido em styles.css -->
        <footer>
            <p>&copy; 2025 Inventário de Itens</p>
        </footer>
    </body>

</html>