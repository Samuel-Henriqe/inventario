<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <!-- ===== CONFIGURAÇÕES BÁSICAS DO DOCUMENTO ===== -->
    <!-- Metadados essenciais para renderização correta e responsividade -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventário</title>
    
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
    <!-- Header fixo com controles de menu para diferentes tamanhos de tela -->
    <header class="d-flex align-items-center justify-content-between px-3" style="height:var(--header-height);">
          <div>
            <!-- Botão de menu para dispositivos móveis (visível em telas pequenas) -->
            <button class="btn btn-outline-light d-md-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasMenu" aria-controls="offcanvasMenu">☰</button>
            
            <!-- Botão de menu para desktop (visível apenas em telas médias e grandes) -->
            <button class="btn btn-outline-light d-none d-md-inline-block menu-toggle ms-2" title="Abrir/Fechar menu">☰</button>
        </div>
        
        <!-- Título principal da página -->
        <h1>Inventário de Itens</h1>
    </header>

    <!-- ===== MENU OFFCANVAS MÓVEL ===== -->
    <!-- Menu lateral deslizante para dispositivos móveis -->
    <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasMenu" aria-labelledby="offcanvasMenuLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasMenuLabel">Menu</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        
        <!-- Conteúdo do menu offcanvas -->
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

    <!-- ===== MENU LATERAL DESKTOP ===== -->
    <!-- Menu lateral para telas maiores, controlado por JavaScript -->
    <div id="menulocalizacao" class="d-none d-md-block" style="position: fixed; top: 66px; left: -250px; width: 250px; height: calc(100vh - 66px); background: var(--primary); border-right: 1px solid #dee2e6; z-index: 1010; padding: 20px 0; transition: left 0.3s ease;">
        <nav>
            <ul class="menulocalizacao">
                <li><a href="home.php">Home</a></li>
                <li><a href="cadastro-lista-itens.php">Cadastrar item</a></li>
                <li><a href="localizacao.php">Localização</a></li>
                <li><a href="movimento.php">Movimentação</a></li>
                <li><a href="item.php">Item</a></li>
                <li><a href="categorias.php">Categorias</a></li>
                <li><a href="usuarios.php">Usuários</a></li>
                <li><a href="relatorios.php">Relatórios</a></li>
            </ul>
        </nav>
    </div>
    
    <style>
        /* === ESTILOS ESPECÍFICOS DO MENU LATERAL === */
        #menulocalizacao.open {
            left: 0 !important;
        }
        
        /* Estilos APENAS dos links dentro do menu lateral */
        #menulocalizacao .menulocalizacao a {
            color: white !important;
            text-decoration: none !important;
            padding: 12px 20px;
            display: block;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.2s ease;
        }
        
        #menulocalizacao .menulocalizacao a:hover {
            background-color: rgba(255, 255, 255, 0.1) !important;
            color: white !important;
            border-left: 4px solid #ffffff;
            padding-left: 16px;
        }
    </style>
    
<main>
    <!-- ===== SEÇÃO DE TABELA DE LOCALIZAÇÕES ===== -->
    <!-- Tabela responsiva que exibe todas as localizações cadastradas no sistema -->
    <div id="tabela_de_localizacao">
        <h1>Localizações Cadastradas</h1>
        <!-- Tabela Bootstrap com listras alternadas e efeito hover -->
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Nome da Localização</th>
                    <th>Descrição da Localização</th>
                    <th>Ações</th>
                </tr>
            </thead>
            
            <!-- Corpo da tabela preenchido dinamicamente via PHP -->
            <tbody>
                <!-- ===== GERAÇÃO DINÂMICA DE DADOS ===== -->
                <!-- PHP Loop que busca e exibe todas as localizações do banco de dados -->
                <?php
                    // Inclui o controller que executa a consulta SQL das localizações
                    require '../controller/select/select_localizacao.php';
                    
                    // Verifica se existem dados antes de fazer o loop
                    if (isset($localizacao) && is_array($localizacao) && count($localizacao) > 0) {
                        // Loop através de cada localização retornada da consulta
                        foreach ($localizacao as $local) {
                        echo "<tr>";
                        
                        // Exibe cada campo da localização com escape de caracteres especiais
                        echo "<td>" . htmlspecialchars($local['nome'] ?? '') . "</td>";
                        echo "<td>" . htmlspecialchars($local['descricao'] ?? '') . "</td>";
                        
                        // Coluna de ações com botões de controle
                        echo "<td>";
                                
                                // Botão de edição - abre modal com campos preenchidos
                                echo "<button id='editbtn' class='btn btn-sm btn-primary me-1' onclick='editarItem(this, \"" . htmlspecialchars($local['id'], ENT_QUOTES) . "\")'>Editar</button>";
                                // Botão de exclusão - confirma antes de deletar
                                echo "<button id='deletebtn' class='btn btn-sm btn-danger me-1' onclick='excluirItem(this, \"" . htmlspecialchars($local['id'], ENT_QUOTES) . "\")'>Excluir</button>";

                                // Botão de geração de etiqueta QR Code
                                
                                echo "<button class='etiquetabtn btn btn-sm btn-secondary js-qr-btn' onclick='gerarQRCodeParaItem(this)'>Etiqueta</button>";
                        echo "</td>";
                            echo "</tr>";
                        
                        }
                    } else {
                        echo "<tr><td colspan='4'>Nenhuma localização encontrada.</td></tr>";
                    }
                ?>
            </tbody>
        </table>
    </div>
    <!-- ===== SEÇÃO DE FORMULÁRIO DE CADASTRO ===== -->
    <!-- Formulário responsivo para adicionar novas localizações ao sistema -->
    <div id="adicionar-localizacao">
        <h2>Adicionar Nova Localização</h2>
        
        <!-- Formulário que envia dados via POST para o controller de inserção -->
        <form action="../controller/insert/insert_localizacao.php" method="POST" id="localizacao-form">
            
            <!-- Campo obrigatório para nome da localização -->
            <div class="mb-3">
                <label for="nome" class="form-label">Nome da Localização</label>
                <input type="text" id="nome" name="nome" class="form-control" required>
            </div>

            <!-- Campo obrigatório para descrição detalhada da localização -->
            <div class="mb-3">
                <label for="descricao" class="form-label">Descrição da Localização</label>
                <input type="text" id="descricao" name="descricao" class="form-control" required>
            </div>

            <!-- Campo obrigatório para responsável pela localização -->


            <!-- Botão de submissão do formulário -->
            <button type="submit" class="btn btn-primary">Adicionar Localização</button>

            <!-- Mensagem de sucesso -->
             <?php 
                if(isset($_GET['sucesso']) && $_GET['sucesso'] === 'sim'){
                    echo "<p style='color: green;'>Localização cadastrada com sucesso!</p>";
                } 
            ?>

        </form>
    </div>

    <!-- ===== SCRIPTS JAVASCRIPT ===== -->
    <!-- SweetAlert2 para alertas e modais modernos -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- Override do window.alert() padrão para usar SweetAlert2 -->
    <script src="../view/js/alert-override.js"></script>

    <!-- Script para controle responsivo do menu lateral -->
    <script src="../view/js/menu-toggle.js"></script>

    <!-- Script personalizado para funções da página -->
    <script>
        // ===== FUNÇÃO UTILITÁRIA PARA ESCAPE DE HTML =====
        // Escapa caracteres especiais para uso seguro em HTML e inputs
        function escapeHtml(text) {
            if (!text && text !== 0) return '';
            return String(text)
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#039;');
        }
        function excluirItem( btn, id_localizacao) {
            const tr = btn.closest('tr');
            if (!tr) return;
            // Modal de confirmação com SweetAlert2
            Swal.fire({
                title: 'Confirma exclusão?',
                text: 'Tem certeza que deseja excluir este item?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sim, excluir',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (!result.isConfirmed) return;
                
                // Requisição AJAX para o controller de exclusão
                fetch('../controller/delete/delete_localizacao.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: 'id_local=' + encodeURIComponent(id_localizacao)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.sucesso) {
                        // Sucesso: remove linha da tabela e exibe confirmação
                        Swal.fire('Excluído', 'Item excluído com sucesso.', 'success').then(() => {
                            const tr = btn.closest('tr');
                            if (tr) tr.remove();
                        });
                    } else {
                        // Erro retornado pelo servidor
                        Swal.fire('Erro', data.erro || 'Erro ao excluir item.', 'error');
                    }
                })
                .catch(error => {
                    // Erro de conexão ou parsing
                    console.error('Erro na requisição:', error);
                    Swal.fire('Erro', 'Erro ao conectar com o servidor.', 'error');
                });
            });
        }
        // Função para excluir localização (placeholder)
        // ===== FUNÇÃO DE EDIÇÃO DE ITEM =====
        // Edita item in-place via modal SweetAlert2 com campos preenchidos
        function editarItem(btn, id_localizacao) {
            const tr = btn.closest('tr');
            if (!tr) return;

            // Mapeia dados das colunas da tabela (índices devem corresponder à estrutura da tabela)
            const cols = tr.querySelectorAll('td');
            const nome = cols[0].textContent.trim();
            const descricao = cols[1].textContent.trim();
            const responsavel = cols[2].textContent.trim();

            // Modal de edição com campos preenchidos
            Swal.fire({
            title: 'Editar localização',
            html:
                '<input id="swal-nome" class="swal2-input" placeholder="Nome da Localização" value="' + escapeHtml(nome) + '">' +
                '<input id="swal-descricao" class="swal2-input" placeholder="Descrição da Localização" value="' + escapeHtml(descricao) + '">' +
                '<input id="swal-responsavel" class="swal2-input" placeholder="Responsável" value="' + escapeHtml(responsavel) + '">',
            focusConfirm: false,
            showCancelButton: true,
            confirmButtonText: 'Salvar',
            // Coleta valores dos campos do modal
            preConfirm: () => {
                return {
                nome: document.getElementById('swal-nome').value.trim(),
                descricao: document.getElementById('swal-descricao').value.trim(),
                responsavel: document.getElementById('swal-responsavel').value.trim(),
                };
            }
            }).then((result) => {
            if (!result.isConfirmed) return;
            
            // Prepara dados para envio via URLSearchParams
            const form = new URLSearchParams();
            const values = result.value;
            form.append('id_local', id_localizacao);
            form.append('nome', values.nome);
            form.append('descricao', values.descricao);
            form.append('responsavel', values.responsavel);

            // Requisição AJAX para o controller de atualização
            fetch('../controller/update/update_localizacao.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: form.toString()
            })
            .then(response => response.json())
            .then(data => {
                if (data.sucesso) {
                // Sucesso: atualiza linha da tabela sem recarregar página
                Swal.fire('Atualizado', 'Localização atualizada com sucesso.', 'success').then(() => {
                    cols[0].textContent = values.nome;
                    cols[1].textContent = values.descricao;
                    cols[2].textContent = values.responsavel;
                });
                } else {
                // Erro retornado pelo servidor
                Swal.fire('Erro', data.erro || 'Erro ao atualizar localização.', 'error');
                }
            })
            .catch(error => {
                // Erro de conexão ou parsing
                console.error('Erro na requisição:', error);
                Swal.fire('Erro', 'Erro ao conectar com o servidor.', 'error');
            });
            });
        }
    </script>



    </main>
</body>

<!-- ===== RODAPÉ DA PÁGINA ===== -->
<!-- Footer simples com informações de copyright -->
<footer>
    <p>&copy; 2025 Inventário de Itens</p>
</footer>

</html>