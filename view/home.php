<!DOCTYPE html>
<html lang="pt-BR">

    <!-- ========================================
        CABEÇALHO DO DOCUMENTO HTML
        ========================================
        Página principal do sistema - Dashboard com navegação
    -->
    <head>
        <!-- Configurações básicas do documento -->
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Home - Sistema de Inventário</title>
        
        <!-- FOLHAS DE ESTILO (CSS) -->
        <!-- Bootstrap CSS: Framework CSS para responsividade e componentes -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        
        <!-- Estilos personalizados: cores do projeto, header fixo, footer -->
        <link rel="stylesheet" href="styles.css">
        
        <!-- Overrides específicos: utilitários para imagens, QR codes e offcanvas -->
        <!-- IMPORTANTE: carregado após styles.css para sobrescrever estilos -->
        <link rel="stylesheet" href="bootstrap-overrides.css">

            <!-- SCRIPTS JAVASCRIPT -->
        <!-- Bootstrap Bundle: JavaScript para componentes interativos -->
        <!-- Inclui Popper.js para tooltips, dropdowns, modais -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
        
        <!-- Script personalizado: controle do menu lateral -->
        <!-- Gerencia abertura/fechamento e persistência no localStorage -->
        <script src="js/menu-toggle.js"></script>

        <!-- RODAPÉ -->
        <!-- Footer simples com copyright -->
        <!-- Estilo definido em styles.css -->
    </head>
    <br><br><br>
    <!-- ========================================
        CORPO DA PÁGINA
        ========================================
        Dashboard principal com navegação em grid responsivo
    -->
    <body>
        <!-- CABEÇALHO FIXO COM NAVEGAÇÃO -->
        <!-- Header responsivo: botões de menu para mobile e desktop -->
        <header class="d-flex align-items-center justify-content-between px-3" 
                style="height:var(--header-height);">
            

            
            <!-- TÍTULO PRINCIPAL -->
            <h1 class="mb-0">Bem-vindo ao Sistema de Inventário</h1>
        </header>

        <!-- ESPAÇAMENTO VISUAL -->
        <!-- Compensação adicional para o header fixo -->

        
        <!-- TEXTO INFORMATIVO -->
        <!-- Instrução para o usuário sobre como navegar -->
        <p id="info" class="text-center" style="top: auto; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);"><b>Utilize o menu para navegar pelas funcionalidades do sistema.</b></p>

        <!-- DASHBOARD PRINCIPAL -->
        <!-- Container Bootstrap com grid responsivo para os botões de navegação -->
        <div id="home" class="container" style="margin-top:60px;">
            
            <!-- GRID RESPONSIVO DE BOTÕES -->
            <!-- row-cols-*: define quantas colunas por breakpoint -->
            <!-- 1 coluna mobile, 2 tablet, 3 desktop -->
            <!-- g-3: gap/espaçamento entre itens -->
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3 justify-content-center">
                
                <!-- FUNCIONALIDADES PRINCIPAIS -->
                
                <!-- Cadastrar Item: formulário para novos itens -->
                <div class="col text-center">
                    <a href="cadastro-lista-itens.php" class="btn btn-success btn-lg w-100 py-4">
                        Cadastrar item
                    </a>
                </div>
                
                <!-- Localização: gerenciar locais/setores -->
                <div class="col text-center">
                    <a href="localizacao.php" 
                    class="btn btn-success btn-lg w-100 py-4">
                        Localização
                    </a>
                </div>
                
                <!-- Movimentação: transferências de itens -->
                <div class="col text-center">
                    <a href="/view/movimento.php" 
                    class="btn btn-success btn-lg w-100 py-4">
                        Movimentação
                    </a>
                </div>
                
                <!-- Item: consultar/editar itens existentes -->
                <div class="col text-center">
                    <a href="item.php" 
                    class="btn btn-success btn-lg w-100 py-4">
                        Item
                    </a>
                </div>
                
                <!-- Categorias: gerenciar tipos de itens -->
                <div class="col text-center">
                    <a href="categorias.php" 
                    class="btn btn-success btn-lg w-100 py-4">
                        Categorias
                    </a>
                </div>
                
                <!-- Usuários: administração de contas -->
                <div class="col text-center">
                    <a href="usuarios.php" 
                    class="btn btn-success btn-lg w-100 py-4">
                        Usuários
                    </a>
                </div>
                
                <!-- Relatórios: visualização de dados -->
                <div class="col text-center">
                    <a href="relatorios.php" 
                    class="btn btn-success btn-lg w-100 py-4">
                        Relatórios
                    </a>
                </div>
                
                <!-- LOGOUT -->
                <!-- Botão diferenciado (outline-secondary) para sair -->
                <!-- Retorna para a página de login (../index.php) -->
                <div class="col text-center">
                    <a href="../index.php" 
                    class="btn btn-outline-secondary btn-lg w-100 py-4">
                        Sair
                    </a>
                </div>
            </div>
        </div>

        <!-- ESPAÇAMENTO INFERIOR -->
        <!-- Espaço visual antes do footer -->
        <br><br><br>


        <footer>
            <p>&copy; 2025 Inventário de Itens</p>
        </footer>
    </body>

</html>