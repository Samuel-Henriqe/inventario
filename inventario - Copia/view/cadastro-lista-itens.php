<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventário</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    
    <header>
        <h1>Inventário de Itens</h1>
    </header>
    <div id="menu">
            <ul>
                <a href="home.php">Home</a>
            </ul>

        <br> <br>
            <ul>
              <a href="\localizacao.php">Localização</a>

            </ul>
        <br> <br>

            <ul>
             <a href="cadastro-lista-itens.php">Cadastro de Itens</a>

            </ul>

        <br> <br>

            <ul>
             <a href="movimento.php">Movimentação</a>

            </ul>
        <br> <br>
            <ul>
             <a href="relatorio.php">Relatórios</a>

            </ul>
        <br> <br>
            <ul>
             <a href="../index.php">Sair</a>
            </ul>
        </div> 
    <main>  

        <section id="itemlist">
            <h2>Cadastro de itens</h2>

                <table>
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Número do Tombamento</th>
                            <th>Descrição</th>
                            <th>Unidade de Medida</th>
                            <th>Status</th>
                            <th>Data de Aquisição</th>
                            <th>localização</th>
                            <th>Categoria</th>
                            <th> Ações </th>
                        </tr>
                    </thead>
                    <tbody id="item-table-body">
                    
                        
                           <!-- Aqui começa o código PHP para listar os itens do banco de dados -->

                            <?php
                                require '../controller/select/select_item.php';
                                foreach ($item as $itens) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($itens['nome_item']) . "</td>";
                                echo "<td>" . htmlspecialchars($itens['numero_tombamento']) . "</td>";
                                echo "<td>" . htmlspecialchars($itens['descricao_item']) . "</td>";
                                echo "<td>" . htmlspecialchars($itens['unidade_de_medida']) . "</td>";
                                echo "<td>" . htmlspecialchars($itens['status_item']) . "</td>";
                                echo "<td>" . htmlspecialchars($itens['data_aquisicao']) . "</td>";
                                echo "<td>" . htmlspecialchars($itens['nome_local']) . "</td>";
                                echo "<td>" . htmlspecialchars($itens['nome_categoria']) . "</td>";
                                echo "<td>";
                                echo "<button id='editbtn' onclick='editarItem(this, \"" . htmlspecialchars($itens['numero_tombamento'], ENT_QUOTES) . "\")'>Editar</button>";
                                echo "<button id='deletebtn' onclick='excluirItem(this, \"" . htmlspecialchars($itens['numero_tombamento'], ENT_QUOTES) . "\")'>Excluir</button>";
                                // chama função passando o botão para gerar QR apenas na linha clicada
                                echo "<button class='etiquetabtn' onclick='gerarQRCodeParaItem(this)'>Etiqueta</button>";
                                echo "</td>";
                                echo "</tr>";
                                }
                            ?>
                            <!-- Aqui termina o código PHP -->
                    </tbody>
                   
                </table>  
        </section>

        <section id = form-section>
            <h2>Adicionar Novo Item</h2>
           <form id="itemform" action="../controller/insert/insert_item.php" method="POST">
    <label for="numero_tombamento">Número do tombamento:</label>
    <input type="text" id="numero_tombamento" name="numero_tombamento" required>

    <label for="nome_item">Nome:</label>
    <input type="text" id="nome_item" name="nome_item" required>

    <label for="descricao_item">Descrição:</label>
    <input type="text" id="descricao_item" name="descricao_item" required>

    <label for="unidade_de_medida">Unidade de Medida:</label>
    <input type="text" id="unidade_de_medida" name="unidade_de_medida" required>

    <label for="status_item">Status:</label>
    <select name="status_item" id="status_item" required>
        <option value="">Selecione o status</option>
        <option value="ativo">Ativo</option>
        <option value="inativo">Inativo</option>
        <option value="desativado">Desativado</option>
    </select>

    <label for="data_aquisicao">Data de Aquisição:</label>
    <input type="date" id="data_aquisicao" name="data_aquisicao" required>

    <label for="id_localizacao">Localização:</label>
    <select name="id_localizacao" id="localizacao_item" required>
        <option value="">Carregando localizações...</option>
    </select>

    <label for="categoria">Categoria:</label>
    <select name="id_categoria" id="categoria_item" required>
        <option value="">Carregando categorias...</option>
    </select>

    <br><br>
    <button type="submit">Adicionar Item</button>
</form>
<?php if(isset($_GET['cadastro']) && $_GET['cadastro'] === 'sucesso'){
    echo "<p style='color: green;'>Item cadastrado com sucesso!</p>";
} ?>

<!-- Coloque os scripts abaixo do form -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="../view/js/alert-override.js"></script>
<script src="../qrcode/qrcode.js"></script>
<script src="../view/js/etiqueta.js"></script>

<script>
  // Escapa para inserir em value de input no template literal
  function escapeHtml(text) {
    if (!text && text !== 0) return '';
    return String(text)
      .replace(/&/g, '&amp;')
      .replace(/</g, '&lt;')
      .replace(/>/g, '&gt;')
      .replace(/"/g, '&quot;')
      .replace(/'/g, '&#039;');
  }

  // Exclusão com SweetAlert2
  function excluirItem(btn, numero_de_tombamento) {
    Swal.fire({
      title: 'Confirma exclusão?',
      text: 'Tem certeza que deseja excluir este item?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Sim, excluir',
      cancelButtonText: 'Cancelar'
    }).then((result) => {
      if (!result.isConfirmed) return;
      fetch('../controller/delete/delete_item.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'id=' + encodeURIComponent(numero_de_tombamento)
      })
      .then(response => response.json())
      .then(data => {
        if (data.sucesso) {
          Swal.fire('Excluído', 'Item excluído com sucesso.', 'success').then(() => {
            // remove linha da tabela
            const tr = btn.closest('tr');
            if (tr) tr.remove();
          });
        } else {
          Swal.fire('Erro', data.erro || 'Erro ao excluir item.', 'error');
        }
      })
      .catch(error => {
        console.error('Erro na requisição:', error);
        Swal.fire('Erro', 'Erro ao conectar com o servidor.', 'error');
      });
    });
  }

  // Edição in-place via modal SweetAlert2
  function editarItem(btn, numero_de_tombamento) {
    const tr = btn.closest('tr');
    if (!tr) return;

    // Mapeia colunas atuais (ajuste índice se a tabela mudar)
    const cols = tr.querySelectorAll('td');
    const nome = cols[0].textContent.trim();
    const numero = cols[1].textContent.trim();
    const descricao = cols[2].textContent.trim();
    const unidade = cols[3].textContent.trim();
    const status = cols[4].textContent.trim();
    const dataAq = cols[5].textContent.trim();
    const localizacao = cols[6].textContent.trim();
    const categoria = cols[7].textContent.trim();

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
      const form = new URLSearchParams();
      const values = result.value;
      // Ajuste de nomes conforme seu update_item.php espera
      form.append('numero_tombamento', values.numero_tombamento);
      form.append('nome_item', values.nome_item);
      form.append('descricao_item', values.descricao_item);
      form.append('unidade_de_medida', values.unidade_de_medida);
      form.append('status_item', values.status_item);
      form.append('data_aquisicao', values.data_aquisicao);
      form.append('id_localizacao', values.id_localizacao);
      form.append('id_categoria', values.id_categoria);

      fetch('../controller/update/update_item.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: form.toString()
      })
      .then(response => response.json())
      .then(data => {
        if (data.sucesso) {
          Swal.fire('Atualizado', 'Item atualizado com sucesso.', 'success').then(() => {
            // Atualiza a linha na tabela sem recarregar
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
          Swal.fire('Erro', data.erro || 'Erro ao atualizar item.', 'error');
        }
      })
      .catch(error => {
        console.error('Erro na requisição:', error);
        Swal.fire('Erro', 'Erro ao conectar com o servidor.', 'error');
      });
    });
  }

  document.addEventListener('DOMContentLoaded', function () {
        // Carrega localizações
        const localizacaoSelect = document.getElementById('localizacao_item');
        fetch('../controller/select/select_localizacao.php')
            .then(response => response.json())
            .then(data => {
                localizacaoSelect.innerHTML = '<option value="">Selecione uma localização</option>';
                data.forEach(localizacao => {
                    const option = document.createElement('option');
                    option.value = localizacao.id_localizacao;
                    option.textContent = localizacao.nome_local;
                    localizacaoSelect.appendChild(option);
                });
            })
            .catch(error => {
                console.error('Erro ao carregar localizações:', error);
                localizacaoSelect.innerHTML = '<option value="">Erro ao carregar localizações</option>';
            });

        // Carrega categorias
        const categoriaSelect = document.getElementById('categoria_item');
        fetch('../controller/select/select_categoria.php')
            .then(response => response.json())
            .then(data => {
                categoriaSelect.innerHTML = '<option value="">Selecione uma categoria</option>';
                data.forEach(categoria => {
                    const option = document.createElement('option');
                    option.value = categoria.id_categoria;
                    option.textContent = categoria.nome_categoria;
                    categoriaSelect.appendChild(option);
                });
            })
            .catch(error => {
                console.error('Erro ao carregar categorias:', error);
                categoriaSelect.innerHTML = '<option value="">Erro ao carregar categorias</option>';
            });
    });
</script>



        </section>



    </main>
 
    <footer>
        <p>&copy; 2025 Inventário de Itens</p>
    </footer>
  


</body>
</html>