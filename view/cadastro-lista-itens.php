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

    <!-- ===== MENU DE NAVEGAÇÃO LATERAL ===== -->
    <!-- Menu de navegação entre as diferentes seções do sistema -->
    <div id="menulocalizacao">
        <ul>
            <a href="home.php">Home</a> 
        </ul>
        <ul>
            <a href="cadastro-lista-itens.php">Cadastrar item</a>
        </ul>
        <ul>
            <a href="localizacao.php">Localização</a>
        </ul>
        <ul>
            <a href="movimento.php">Movimentação</a>
        </ul>
        <ul>
            <a href="item.php">Item</a>
        </ul>
        <ul>
            <a href="categorias.php">Categorias</a>
        </ul>
        <ul>
            <a href="usuarios.php">Usuarios</a>
        </ul>
        <ul>
            <a href="relatorios.php">Relatórios</a>
        </ul>
        <ul>
            <a href="../index.php">Sair</a>
        </ul>
    </div>
    <!-- ===== CONTEÚDO PRINCIPAL DA PÁGINA ===== -->
    <main>
        <!-- ===== SEÇÃO DE LISTAGEM DE ITENS ===== -->
        <!-- Tabela responsiva que exibe todos os itens cadastrados no sistema -->
        <section id="itemlist">
            <h2>Cadastro de itens</h2>

            <!-- Tabela Bootstrap com listras alternadas e efeito hover -->
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Número do Tombamento</th>
                        <th>Descrição</th>
                        <th>Unidade de Medida</th>
                        <th>Status</th>
                        <th>Data de Aquisição</th>
                        <th>Localização</th>
                        <th>Categoria</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                
                <!-- Corpo da tabela preenchido dinamicamente via PHP -->
                <tbody id="item-table-body">
                    <!-- ===== GERAÇÃO DINÂMICA DE DADOS ===== -->
                    <!-- PHP Loop que busca e exibe todos os itens do banco de dados -->
                    <?php
                        // Inclui o controller que executa a consulta SQL dos itens
                        require '../controller/select/select_item.php';
                        
                        // Loop através de cada item retornado da consulta
                        foreach ($item as $itens) {
                            echo "<tr>";
                            
                            // Exibe cada campo do item com escape de caracteres especiais
                            echo "<td>" . htmlspecialchars($itens['nome_item']) . "</td>";
                            echo "<td>" . htmlspecialchars($itens['numero_tombamento']) . "</td>";
                            echo "<td>" . htmlspecialchars($itens['descricao_item']) . "</td>";
                            echo "<td>" . htmlspecialchars($itens['unidade_de_medida']) . "</td>";
                            echo "<td>" . htmlspecialchars($itens['status_item']) . "</td>";
                            echo "<td>" . htmlspecialchars($itens['data_aquisicao']) . "</td>";
                            echo "<td>" . htmlspecialchars($itens['nome_local']) . "</td>";
                            echo "<td>" . htmlspecialchars($itens['nome_categoria']) . "</td>";
                            
                            // Coluna de ações com botões de controle
                            echo "<td>";
                            
                            // Botão de edição - abre modal com campos preenchidos
                            echo "<button id='editbtn' class='btn btn-sm btn-primary me-1' onclick='editarItem(this, \"" . htmlspecialchars($itens['numero_tombamento'], ENT_QUOTES) . "\")'>Editar</button>";
                            
                            // Botão de exclusão - confirma antes de deletar
                            echo "<button id='deletebtn' class='btn btn-sm btn-danger me-1' onclick='excluirItem(this, \"" . htmlspecialchars($itens['numero_tombamento'], ENT_QUOTES) . "\")'>Excluir</button>";
                            
                            // Botão de geração de etiqueta QR Code
                            echo "<button class='etiquetabtn btn btn-sm btn-secondary' onclick='gerarQRCodeParaItem(this)'>Etiqueta</button>";
                            
                            echo "</td>";
                            echo "</tr>";
                        }
                    ?>
                </tbody>
            </table>  
        </section>

        <!-- ===== SEÇÃO DE FORMULÁRIO DE CADASTRO ===== -->
        <!-- Formulário responsivo para adicionar novos itens ao inventário -->
        <section id="form-section">
            <h2>Adicionar Novo Item</h2>
            
            <!-- Formulário que envia dados via POST para o controller de inserção -->
            <form id="itemform" action="../controller/insert/insert_item.php" method="POST">
                
                <!-- Campo obrigatório para número de tombamento (identificador único) -->
                <div class="mb-3">
                    <label for="numero_tombamento" class="form-label">Número do tombamento</label>
                    <input type="text" id="numero_tombamento" name="numero_tombamento" class="form-control" required>
                </div>

                <!-- Campo obrigatório para nome do item -->
                <div class="mb-3">
                    <label for="nome_item" class="form-label">Nome</label>
                    <input type="text" id="nome_item" name="nome_item" class="form-control" required>
                </div>

                <!-- Campo obrigatório para descrição detalhada do item -->
                <div class="mb-3">
                    <label for="descricao_item" class="form-label">Descrição</label>
                    <input type="text" id="descricao_item" name="descricao_item" class="form-control" required>
                </div>

                <!-- Campo obrigatório para unidade de medida (ex: unidade, kg, metro) -->
                <div class="mb-3">
                    <label for="unidade_de_medida" class="form-label">Unidade de Medida</label>
                    <input type="text" id="unidade_de_medida" name="unidade_de_medida" class="form-control" required>
                </div>

                <!-- Select obrigatório para status do item (ativo/inativo/desativado) -->
                <div class="mb-3">
                    <label for="status_item" class="form-label">Status</label>
                    <select name="status_item" id="status_item" class="form-select" required>
                        <option value="">Selecione o status</option>
                        <option value="ativo">Ativo</option>
                        <option value="inativo">Inativo</option>
                        <option value="desativado">Desativado</option>
                    </select>
                </div>

                <!-- Campo obrigatório para data de aquisição -->
                <div class="mb-3">
                    <label for="data_aquisicao" class="form-label">Data de Aquisição</label>
                    <input type="date" id="data_aquisicao" name="data_aquisicao" class="form-control" required>
                </div>

                <!-- Select dinâmico para localização (carregado via JavaScript) -->
                <div class="mb-3">
                    <label for="localizacao" class="form-label">Localização</label>
                    <select name="localizacao" id="localizacao_item" class="form-select" required>
                        <option value="">Carregando localizações...</option>
                    </select>
                </div>

                <!-- Select dinâmico para categoria (carregado via JavaScript) -->
                <div class="mb-3">
                    <label for="categoria" class="form-label">Categoria</label>
                    <select name="id_categoria" id="categoria_item" class="form-select" required>
                        <option value="">Carregando categorias...</option>
                    </select>
                </div>

                <!-- Botão de submissão do formulário -->
                <button type="submit" class="btn btn-primary">Adicionar Item</button>
            </form>
            
            <!-- ===== MENSAGEM DE SUCESSO ===== -->
            <!-- Exibe mensagem de confirmação quando item é cadastrado com sucesso -->
            <?php 
                if(isset($_GET['cadastro']) && $_GET['cadastro'] === 'sucesso'){
                    echo "<p style='color: green;'>Item cadastrado com sucesso!</p>";
                } 
            ?>

        <!-- ===== EXEMPLO DE IMAGEM RESPONSIVA (COMENTADO) ===== -->
        <!-- Template para uso futuro com imagens de itens - implementa lazy loading e srcset responsivo -->
        <!--
        <div class="mt-4">
            <h3>Imagem do item (exemplo)</h3>
            <img src="/uploads/item-480.jpg"
                 srcset="/uploads/item-320.jpg 320w, /uploads/item-480.jpg 480w, /uploads/item-800.jpg 800w"
                 sizes="(max-width: 600px) 100vw, 480px"
                 loading="lazy"
                 class="img-responsive"
                 alt="Imagem do item">
        </div>
        -->

        <!-- ===== SCRIPTS JAVASCRIPT ===== -->
        <!-- Scripts carregados no final do body para otimizar performance -->
        
        <!-- Bootstrap Bundle JS com Popper.js incluído para funcionalidades interativas -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
        
        <!-- SweetAlert2 para alertas e modais modernos -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        
        <!-- Override do window.alert() padrão para usar SweetAlert2 -->
        <script src="../view/js/alert-override.js"></script>
        
        <!-- Biblioteca para geração de QR Codes -->
        <script src="../qrcode/qrcode.js"></script>
        
        <!-- Script especializado para impressão de etiquetas com QR Code -->
        <script src="../view/js/etiqueta.js"></script>

        <!-- Script para controle responsivo do menu lateral -->
        <script src="../view/js/menu-toggle.js"></script>

        <!-- ===== SCRIPT PERSONALIZADO DA PÁGINA ===== -->
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

            // ===== FUNÇÃO DE EXCLUSÃO DE ITEM =====
            // Exclui item com confirmação via SweetAlert2 e atualização dinâmica da tabela
            function excluirItem(btn, numero_de_tombamento) {
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
                    fetch('../controller/delete/delete_item.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                        body: 'id=' + encodeURIComponent(numero_de_tombamento)
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

            // ===== FUNÇÃO DE EDIÇÃO DE ITEM =====
            // Edita item in-place via modal SweetAlert2 com campos preenchidos
            function editarItem(btn, numero_de_tombamento) {
                const tr = btn.closest('tr');
                if (!tr) return;

                // Mapeia dados das colunas da tabela (índices devem corresponder à estrutura da tabela)
                const cols = tr.querySelectorAll('td');
                const nome = cols[0].textContent.trim();
                const numero = cols[1].textContent.trim();
                const descricao = cols[2].textContent.trim();
                const unidade = cols[3].textContent.trim();
                const status = cols[4].textContent.trim();
                const dataAq = cols[5].textContent.trim();
                const localizacao = cols[6].textContent.trim();
                const categoria = cols[7].textContent.trim();

                // Modal de edição com campos preenchidos
                Swal.fire({
                    title: 'Editar item',
                    html:
                        '<input id="swal-nome" class="swal2-input" placeholder="Nome" value="' + escapeHtml(nome) + '">' +
                        '<input id="swal-numero" class="swal2-input" placeholder="Número tombamento" value="' + escapeHtml(numero) + '" readonly>' +
                        '<input id="swal-descricao" class="swal2-input" placeholder="Descrição" value="' + escapeHtml(descricao) + '">' +
                        '<input id="swal-unidade" class="swal2-input" placeholder="Unidade de Medida" value="' + escapeHtml(unidade) + '">' +
                        '<select id="swal-status" class="swal2-select">' +
                        '<option value="ativo"' + (status === 'ativo' ? ' selected' : '') + '>Ativo</option>' +
                        '<option value="inativo"' + (status === 'inativo' ? ' selected' : '') + '>Inativo</option>' +
                        '<option value="desativado"' + (status === 'desativado' ? ' selected' : '') + '>Desativado</option>' +
                        '</select>' +
                        '<input id="swal-data" type="date" class="swal2-input" value="' + escapeHtml(dataAq) + '">' +
                        '<input id="swal-local" class="swal2-input" placeholder="Localização (id ou nome)" value="' + escapeHtml(localizacao) + '">' +
                        '<input id="swal-categoria" class="swal2-input" placeholder="Categoria (id ou nome)" value="' + escapeHtml(categoria) + '">',
                    focusConfirm: false,
                    showCancelButton: true,
                    confirmButtonText: 'Salvar',
                    // Coleta valores dos campos do modal
                    preConfirm: () => {
                        return {
                            nome_item: document.getElementById('swal-nome').value.trim(),
                            numero_tombamento: document.getElementById('swal-numero').value.trim(),
                            descricao_item: document.getElementById('swal-descricao').value.trim(),
                            unidade_de_medida: document.getElementById('swal-unidade').value.trim(),
                            status_item: document.getElementById('swal-status').value,
                            data_aquisicao: document.getElementById('swal-data').value,
                            id_localizacao: document.getElementById('swal-local').value.trim(),
                            id_categoria: document.getElementById('swal-categoria').value.trim()
                        };
                    }
                }).then((result) => {
                    if (!result.isConfirmed) return;
                    
                    // Prepara dados para envio via URLSearchParams
                    const form = new URLSearchParams();
                    const values = result.value;
                    form.append('numero_tombamento', values.numero_tombamento);
                    form.append('nome_item', values.nome_item);
                    form.append('descricao_item', values.descricao_item);
                    form.append('unidade_de_medida', values.unidade_de_medida);
                    form.append('status_item', values.status_item);
                    form.append('data_aquisicao', values.data_aquisicao);
                    form.append('id_localizacao', values.id_localizacao);
                    form.append('id_categoria', values.id_categoria);

                    // Requisição AJAX para o controller de atualização
                    fetch('../controller/update/update_item.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                        body: form.toString()
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.sucesso) {
                            // Sucesso: atualiza linha da tabela sem recarregar página
                            Swal.fire('Atualizado', 'Item atualizado com sucesso.', 'success').then(() => {
                                cols[0].textContent = values.nome_item;
                                cols[1].textContent = values.numero_tombamento;
                                cols[2].textContent = values.descricao_item;
                                cols[3].textContent = values.unidade_de_medida;
                                cols[4].textContent = values.status_item;
                                cols[5].textContent = values.data_aquisicao;
                                cols[6].textContent = values.id_localizacao;
                                cols[7].textContent = values.id_categoria;
                            });
                        } else {
                            // Erro retornado pelo servidor
                            Swal.fire('Erro', data.erro || 'Erro ao atualizar item.', 'error');
                        }
                    })
                    .catch(error => {
                        // Erro de conexão ou parsing
                        console.error('Erro na requisição:', error);
                        Swal.fire('Erro', 'Erro ao conectar com o servidor.', 'error');
                    });
                });
            }
            // ===== INICIALIZAÇÃO DA PÁGINA =====
            // Carrega dados dinâmicos dos selects quando a página termina de carregar
            document.addEventListener('DOMContentLoaded', function () {
                
                // ===== CARREGAMENTO DINÂMICO DE LOCALIZAÇÕES =====
                // Popula o select de localizações via requisição AJAX
                const localizacaoSelect = document.getElementById('localizacao_item');
                fetch('../controller/select/select_localizacao.php')
                    .then(response => response.json())
                    .then(data => {
                        // Limpa select e adiciona opção padrão
                        localizacaoSelect.innerHTML = '<option value="">Selecione uma localização</option>';
                        
                        // Popula com dados retornados do servidor
                        data.forEach(localizacao => {
                            const option = document.createElement('option');
                            option.value = localizacao.id_localizacao;
                            option.textContent = localizacao.nome_local;
                            localizacaoSelect.appendChild(option);
                        });
                    })
                    .catch(error => {
                        // Tratamento de erro na requisição
                        console.error('Erro ao carregar localizações:', error);
                        localizacaoSelect.innerHTML = '<option value="">Erro ao carregar localizações</option>';
                    });

                // ===== CARREGAMENTO DINÂMICO DE CATEGORIAS =====
                // Popula o select de categorias via requisição AJAX
                const categoriaSelect = document.getElementById('categoria_item');
                fetch('../controller/select/select_categoria.php')
                    .then(response => response.json())
                    .then(data => {
                        // Limpa select e adiciona opção padrão
                        categoriaSelect.innerHTML = '<option value="">Selecione uma categoria</option>';
                        
                        // Popula com dados retornados do servidor
                        data.forEach(categoria => {
                            const option = document.createElement('option');
                            option.value = categoria.id_categoria;
                            option.textContent = categoria.nome_categoria;
                            categoriaSelect.appendChild(option);
                        });
                    })
                    .catch(error => {
                        // Tratamento de erro na requisição
                        console.error('Erro ao carregar categorias:', error);
                        categoriaSelect.innerHTML = '<option value="">Erro ao carregar categorias</option>';
                    });
            });
        </script>
    </main>
    
    <!-- ===== RODAPÉ DA PÁGINA ===== -->
    <!-- Footer simples com informações de copyright -->
    <footer>
        <p>&copy; 2025 Inventário de Itens</p>
    </footer>

</body>
</html>