<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Painel de Relatórios — Inventário</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background-color: #f8f9fa; }
    .card { border-radius: 12px; }
    .table-container { max-height: 65vh; overflow-y: auto; }
    .spinner-border { width: 3rem; height: 3rem; }
  </style>
</head>
<body class="p-3">
  <div class="container">
    <h2 class="text-center mb-4">📊 Relatórios do Inventário</h2>

    <!-- Seletor de relatório -->
    <div class="card p-3 mb-3 shadow-sm">
      <div class="row g-3 align-items-end">
        <div class="col-md-4">
          <label for="reportSelect" class="form-label fw-bold">Escolher relatório:</label>
          <select id="reportSelect" class="form-select">
            <option value="">-- Selecione --</option>
            <option value="estoque_atual">Estoque Atual</option>
            <option value="historico_movimentacoes">Histórico de Movimentações</option>
            <option value="itens_sem_movimentacao">Itens sem Movimentação</option>
            <option value="movimentacao_por_usuario">Movimentação por Usuário</option>
            <option value="resumo_movimentacoes">Resumo de Movimentações</option>
            <option value="saldo_por_localizacao">Saldo por Localização</option>
          </select>
        </div>
        <div class="col-md-4">
          <label for="filtro" class="form-label fw-bold">Filtro (opcional):</label>
          <input id="filtro" type="text" class="form-control" placeholder="Ex: nome_item_like=caneta">
        </div>
        <div class="col-md-4">
          <button id="btnBuscar" class="btn btn-primary w-100 fw-bold">🔍 Buscar</button>
        </div>
      </div>
    </div>

    <!-- Área de loading -->
    <div id="loading" class="text-center my-5 d-none">
      <div class="spinner-border text-primary" role="status"></div>
      <p class="mt-3 fw-bold text-primary">Carregando dados...</p>
    </div>

    <!-- Área da tabela -->
    <div id="resultado" class="card p-3 shadow-sm d-none">
      <h5 id="tituloRelatorio" class="mb-3"></h5>
      <div class="table-container">
        <table id="tabela" class="table table-striped table-hover table-bordered">
          <thead class="table-dark"></thead>
          <tbody></tbody>
        </table>
      </div>
    </div>
  </div>

  <script>
    const btnBuscar = document.getElementById('btnBuscar');
    const select = document.getElementById('reportSelect');
    const filtro = document.getElementById('filtro');
    const loading = document.getElementById('loading');
    const resultado = document.getElementById('resultado');
    const titulo = document.getElementById('tituloRelatorio');
    const tabela = document.getElementById('tabela');

    btnBuscar.addEventListener('click', async () => {
      const report = select.value;
      if (!report) {
        alert('Selecione um relatório!');
        return;
      }

      // Monta URL base
      let url = `api.php?report=${encodeURIComponent(report)}&limit=50`;
      if (filtro.value.trim()) url += `&${filtro.value.trim()}`;

      resultado.classList.add('d-none');
      loading.classList.remove('d-none');

      try {
        const res = await fetch(url);
        const json = await res.json();

        loading.classList.add('d-none');
        if (json.error) {
          alert('Erro: ' + json.error);
          return;
        }

        titulo.textContent = `Relatório: ${json.report}`;
        resultado.classList.remove('d-none');

        if (!json.data || json.data.length === 0) {
          tabela.querySelector('thead').innerHTML = '<tr><th>Nenhum dado encontrado</th></tr>';
          tabela.querySelector('tbody').innerHTML = '';
          return;
        }

        // Monta cabeçalhos
        const keys = Object.keys(json.data[0]);
        tabela.querySelector('thead').innerHTML = '<tr>' + keys.map(k => `<th>${k}</th>`).join('') + '</tr>';

        // Monta linhas
        tabela.querySelector('tbody').innerHTML = json.data.map(row => {
          return '<tr>' + keys.map(k => `<td>${row[k] ?? ''}</td>`).join('') + '</tr>';
        }).join('');

      } catch (err) {
        loading.classList.add('d-none');
        alert('Erro ao conectar com o servidor.');
        console.error(err);
      }
    });
  </script>
</body>
</html>
