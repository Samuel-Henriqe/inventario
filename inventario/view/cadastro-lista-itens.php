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
                                echo "<td>" . htmlspecialchars($itens['id_localizacao']) . "</td>";
                                echo "<td>" . htmlspecialchars($itens['id_categoria']) . "</td>";
                                echo "<td>";
                                echo "<button id='edit-btn'>Editar</button>";
                                echo "<button id='delete-btn'>Excluir</button>";
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
    <select name="id_localizacao" id="id_localizacao" required>
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
<script>
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