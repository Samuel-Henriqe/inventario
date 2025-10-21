<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>localização</title>~
    <link rel="stylesheet" href="styles.css">

</head>
<header> localização para os itens</header>

<body>
    <div id=menulocalizacao >
        <ul >
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


    <div id=tabela_de_localizacao>

        <table >
            <thead>
                <tr>
                    <th>Nome da localização</th>
                    <th>Descrição da localização</th>
                    <th>Responsavel</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                            <?php
                                require '../controller/select/select_localizacao1.php';
                                foreach ($item as $local)  {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($local['nome_local']) . "</td>";
                                echo "<td>" . htmlspecialchars($local['descricao_local']) . "</td>";
                                echo "<td>" . htmlspecialchars($local['responsavel']) . "</td>";
                                echo "<td>";
                                echo "<button id='editbtn' onclick='editarItem(this, \"" . htmlspecialchars($local['id_localizacao'], ENT_QUOTES) . "\")'>Editar</button>";
                                echo "<button id='deletebtn' onclick='excluirItem(this, \"" . htmlspecialchars($local['id_localizacao'], ENT_QUOTES) . "\")'>Excluir</button>";
                                echo "</td>";
                                echo "</tr>";
                                }
                            ?>
            </tbody>
        </table>
    </div>
    <div id="adicionar-localizacao">
            <h2>Adicionar Nova Localização</h2>
            <form action="../controller/insert/insert_localizacao.php" method="POST" id="localizacao-form">
                <label for="nome_local">Nome da Localização:</label>
                <input type="text" id="nome_local" name="nome_local" required>

                <label for="descricao_local">Descrição da Localização:</label>
                <input type="text" id="descricao_local" name="descricao_local" required>

                <label for="responsavel">Responsável:</label>
                <input type="text" id="responsavel" name="responsavel" required>

                <button type="submit">Adicionar Localização</button>
            </form>

    </div>
    <footer>
            <p>&copy; 2025 Inventário de Itens</p>
    </footer>
</body>
</html>