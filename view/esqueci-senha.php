<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <!-- ===== CONFIGURAÇÕES BÁSICAS DO DOCUMENTO ===== -->
    <!-- Metadados essenciais para renderização correta e responsividade -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Esqueci minha senha</title>
    
    <!-- ===== FOLHAS DE ESTILO (CSS) ===== -->
    <!-- Bootstrap CSS Framework via CDN para componentes responsivos -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Estilos personalizados do projeto (variáveis CSS, header, footer) -->
    <link rel="stylesheet" href="styles.css">
    
    <!-- Overrides especializados para imagens responsivas e utilitários -->
    <link rel="stylesheet" href="bootstrap-overrides.css">
</head>
<body>
    <!-- ===== CABEÇALHO DA PÁGINA ===== -->
    <!-- Header simples para a página de recuperação de senha -->
    <header>
        <h1>Recuperar Senha</h1>
    </header>
    
    <!-- ===== CONTEÚDO PRINCIPAL ===== -->
    <!-- Seção principal com formulário de recuperação de senha -->
    <main>
        <!-- Container centralizado com largura limitada para melhor UX -->
        <div class="container" style="max-width:520px; margin-top:90px;">
            
            <!-- ===== FORMULÁRIO DE RECUPERAÇÃO DE SENHA ===== -->
            <!-- Formulário que envia o email para o controller de atualização de senha -->
            <form action="../controller/update/update_senha_usuario.php" method="POST" id="forgot-password-form">
                
                <!-- Campo obrigatório para inserção do email do usuário -->
                <div class="mb-3">
                    <label for="email" class="form-label">Digite seu e-mail</label>
                    <input type="email" id="email" name="email" class="form-control" required>
                </div>
                
                <!-- Botão de submissão do formulário -->
                <button class="btn btn-primary" id="enviar-btn" type="submit">Enviar</button>
            </form>
        </div>
    </main>
    
    <!-- ===== SCRIPTS JAVASCRIPT ===== -->
    <!-- Bootstrap Bundle JS com Popper.js incluído para funcionalidades interativas -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
</body>

<!-- ===== RODAPÉ DA PÁGINA ===== -->
<!-- Footer simples com informações de copyright, separado por quebras de linha -->
<br><br><br>
<footer>
    <p>&copy; 2025 Inventário de Itens</p>
</footer>
</html>