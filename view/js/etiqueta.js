/* ===================================================
   SISTEMA DE GERAÇÃO DE QR CODES PARA ETIQUETAS
   ===================================================
   
   PROPÓSITO:
   - Gera QR Codes para itens do inventário
   - Oferece funcionalidade de impressão das etiquetas
   - Suporte para modal (SweetAlert2) e inserção em tabelas
   
   DEPENDÊNCIAS:
   - QRCode.js (biblioteca externa para geração de QR)
   - SweetAlert2 (para modais bonitos - opcional)
   
   ESTRUTURA DA TABELA ESPERADA:
   [0] = Nome do item
   [1] = Número do Tombamento
   [2] = Descrição
   [3] = Unidade
   [4] = Status
   [5] = Data de Aquisição
   [6] = Localização
   [7] = Categoria
   
   FUNÇÕES PRINCIPAIS:
   1. gerarQRCodesParaItens() - Gera QR para toda a tabela
   2. gerarQRCodeParaLinha() - Gera QR para linha específica
   3. gerarQRCodeParaItem() - Gera QR em modal
   4. imprimirQRCode() - Abre janela de impressão
   ===================================================
*/

/* ========================================
   1. GERAÇÃO EM MASSA DE QR CODES
   ========================================
   Percorre toda a tabela gerando QR para cada linha
*/

/**
 * Gera QR Codes para todos os itens de uma tabela
 * 
 * FUNCIONAMENTO:
 * - Busca tabela por ID 'tabela-itens' ou primeiro <table> encontrado
 * - Pula linha de cabeçalho (começa do índice 1)
 * - Evita gerar QR duplicado (verifica dataset.qrGenerated)
 * - Chama gerarQRCodeParaLinha() para cada linha
 */
function gerarQRCodesParaItens() {
    // Busca a tabela de itens na página
    const tabela = document.getElementById('tabela-itens') || document.querySelector('table');
    if (!tabela) return; // Sai se não encontrar tabela

    // Percorre todas as linhas (exceto cabeçalho)
    for (let i = 1; i < tabela.rows.length; i++) {
        const row = tabela.rows[i];
        
        // Pula se QR já foi gerado para esta linha
        if (row.dataset.qrGenerated === '1') continue;
        
        // Gera QR Code para a linha atual
        gerarQRCodeParaLinha(row);
    }
}

/* ========================================
   2. GERAÇÃO DE QR CODE PARA LINHA ESPECÍFICA
   ========================================
   Cria QR Code e botão de impressão em uma linha da tabela
*/

/**
 * Gera QR Code para uma linha específica da tabela
 * 
 * PARÂMETROS:
 * @param {HTMLTableRowElement} row - Linha da tabela HTML
 * 
 * FUNCIONAMENTO:
 * - Extrai dados de todas as células da linha
 * - Monta string com informações formatadas
 * - Cria nova célula com QR Code
 * - Adiciona botão de impressão
 * - Marca linha como processada
 */
function gerarQRCodeParaLinha(row) {
    // Validações iniciais
    if (!row || row.dataset.qrGenerated === '1') return;

    // EXTRAÇÃO DE DADOS DAS CÉLULAS
    // Verifica se célula existe e tem conteúdo, senão usa string vazia
    const nome = (row.cells[0] && row.cells[0].innerText) ? row.cells[0].innerText.trim() : '';
    const numero_tombamento = (row.cells[1] && row.cells[1].innerText) ? row.cells[1].innerText.trim() : '';
    const descricao = (row.cells[2] && row.cells[2].innerText) ? row.cells[2].innerText.trim() : '';
    const unidade = (row.cells[3] && row.cells[3].innerText) ? row.cells[3].innerText.trim() : '';
    const status = (row.cells[4] && row.cells[4].innerText) ? row.cells[4].innerText.trim() : '';
    const dataAq = (row.cells[5] && row.cells[5].innerText) ? row.cells[5].innerText.trim() : '';
    const localizacao = (row.cells[6] && row.cells[6].innerText) ? row.cells[6].innerText.trim() : '';
    const categoria = (row.cells[7] && row.cells[7].innerText) ? row.cells[7].innerText.trim() : '';

    // FORMATAÇÃO DO TEXTO PARA O QR CODE
    // Template string com todas as informações do item
    const info = `Número de Tombamento: ${numero_tombamento}\nNome: ${nome}\nDescrição: ${descricao}\nUnidade: ${unidade}\nStatus: ${status}\nData: ${dataAq}\nLocalização: ${localizacao}\nCategoria: ${categoria}`;

    // VALIDAÇÃO PARA EVITAR DUPLICAÇÃO
    // Verifica se já existe célula QR nesta linha
    if (row.querySelector('.qr-cell')) return;

    const qrCell = row.insertCell(-1);
    qrCell.className = 'qr-cell';
    const qrDiv = document.createElement('div');
    qrDiv.className = 'qr-code';
    qrCell.appendChild(qrDiv);

    if (typeof QRCode !== 'undefined') {
        try {
            new QRCode(qrDiv, {
                text: info,
                width: 100,
                height: 100
            });
            // botão de impressão para cada QR gerado na linha
            const printWrapper = document.createElement('div');
            printWrapper.className = 'qr-print-wrapper';
            const printBtn = document.createElement('button');
            printBtn.type = 'button';
            printBtn.className = 'btn btn-sm btn-outline-secondary qr-print-btn';
            printBtn.setAttribute('aria-label', 'Imprimir QR');
            printBtn.textContent = 'Imprimir QR';
            printBtn.addEventListener('click', function () {
                if (window.imprimirQRCode) window.imprimirQRCode(qrDiv, info);
            });
            printWrapper.appendChild(printBtn);
            qrCell.appendChild(printWrapper);
            row.dataset.qrGenerated = '1';
        } catch (e) {
            console.error('Erro ao gerar QRCode para linha', e);
            qrDiv.textContent = 'QR erro';
        }
    } else {
        console.warn('QRCode.js não encontrado. Importe ../qrcode/qrcode.js antes de etiqueta.js');
        qrDiv.textContent = 'QR lib ausente';
    }
}

/* Função global para imprimir um QR a partir do container gerado pelo QRCode.js
   - qrContainer: elemento DOM que contém o QR (div onde o QR foi criado)
   - infoText: texto informativo a ser mostrado junto com o QR na página de impressão
*/
window.imprimirQRCode = function (qrContainer, infoText) {
    try {
        const container = (typeof qrContainer === 'string') ? document.querySelector(qrContainer) : qrContainer;
        if (!container) return alert('Conteúdo do QR não encontrado para impressão.');

        // tenta obter src a partir de canvas/img/svg
        let src = null;
        const canvas = container.querySelector('canvas');
        const img = container.querySelector('img');
        const svg = container.querySelector('svg');
        if (canvas) {
            src = canvas.toDataURL('image/png');
        } else if (img) {
            src = img.src;
        } else if (svg) {
            const serializer = new XMLSerializer();
            const svgStr = serializer.serializeToString(svg);
            src = 'data:image/svg+xml;charset=utf-8,' + encodeURIComponent(svgStr);
        }

        const printWindow = window.open('', '_blank', 'width=420,height=680');
        if (!printWindow) return alert('Não foi possível abrir a janela de impressão. Verifique bloqueadores de pop-ups.');

        function escapeHtml(s) {
            if (!s) return '';
            return String(s).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
        }

        printWindow.document.write('<!doctype html><html><head><meta charset="utf-8"><title>Imprimir QR</title>');
        printWindow.document.write('<style>body{font-family:Arial,Helvetica,sans-serif;padding:18px;text-align:center;color:#111}img{max-width:100%;height:auto}pre{white-space:pre-wrap;text-align:left;margin-top:12px;background:#f8f9fa;padding:10px;border-radius:6px;border:1px solid rgba(0,0,0,0.04)}</style>');
        printWindow.document.write('</head><body>');
        if (src) printWindow.document.write('<img src="' + src + '" alt="QR Code">');
        if (infoText) printWindow.document.write('<pre>' + escapeHtml(infoText) + '</pre>');
        printWindow.document.write('</body></html>');
        printWindow.document.close();
        printWindow.focus();
        printWindow.print();
        // não fechamos automaticamente — permitir ao usuário revisar
    } catch (err) {
        console.error('Erro ao preparar impressão do QR:', err);
        alert('Erro ao preparar impressão do QR. Veja console para detalhes.');
    }
};

/*
    Gera QR Code a partir das informações da linha da tabela (dentro do form)
    e mostra em um modal SweetAlert2. Requer:
    - SweetAlert2 carregado antes deste script
    - QRCode.js carregado antes deste script
*/

(function () {
    function coletarInfoDaLinha(tr) {
        if (!tr) return { info: '', numero: '' };
        const cells = tr.querySelectorAll('td');
        const nome = cells[0] ? cells[0].innerText.trim() : '';
        const numero_tombamento = cells[1] ? cells[1].innerText.trim() : '';
        const descricao = cells[2] ? cells[2].innerText.trim() : '';
        const unidade = cells[3] ? cells[3].innerText.trim() : '';
        const status = cells[4] ? cells[4].innerText.trim() : '';
        const data = cells[5] ? cells[5].innerText.trim() : '';
        const local = cells[6] ? cells[6].innerText.trim() : '';
        const categoria = cells[7] ? cells[7].innerText.trim() : '';

        const info = [
            `Número de Tombamento: ${numero_tombamento}`,
            `Nome: ${nome}`,
            `Descrição: ${descricao}`,
            `Unidade: ${unidade}`,
            `Status: ${status}`,
            `Data de Aquisição: ${data}`,
            `Localização: ${local}`,
            `Categoria: ${categoria}`
        ].filter(Boolean).join('\n');

        // Corrige: retorna numero_tombamento como 'numero' para uso posterior
        return { info, numero: numero_tombamento };
    }

    // Gera QR e mostra em modal; é chamada com onclick="gerarQRCodeParaItem(this)"
    function gerarQRCodeParaItem(btn) {
        if (!btn) return;
        const tr = btn.closest('tr');
        if (!tr) {
            console.warn('Linha não encontrada para gerar etiqueta.');
            return;
        }

        const { info, numero } = coletarInfoDaLinha(tr);

        // Limite prático: se o texto for muito grande, use URL em vez do texto completo.
        // Ajuste threshold conforme testes (em bytes/characters). Aqui usamos 900 chars como seguro.
        const MAX_CHARS_SAFE = 900;
        let qrText = info;
        let usingUrl = false;

        if (info.length > MAX_CHARS_SAFE) {
            usingUrl = true;
            // monta URL pública para página que mostra os detalhes do item
            // ajusta o caminho se seu projeto estiver em subpasta diferente
            const base = window.location.origin + '/inventario/view/etiqueta.php';
            qrText = `${base}?numero=${encodeURIComponent(numero)}`;
        }

        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: 'Etiqueta - QR Code',
                html:
                  '<div id="swal-qr" style="display:flex;justify-content:center;margin-bottom:10px;"></div>' +
                  '<pre id="swal-info" style="white-space:pre-wrap;text-align:left;"></pre>' +
                  (usingUrl ? '<p style="font-size:0.9em;color:#666">QR contém um link para os detalhes completos.</p>' : ''),
                width: 460,
                showCloseButton: true,
                showDenyButton: true,
                confirmButtonText: 'Fechar',
                denyButtonText: 'Imprimir QR',
                didOpen: () => {
                    const qrContainer = document.getElementById('swal-qr');
                    const infoPre = document.getElementById('swal-info');
                    if (infoPre) infoPre.textContent = info;

                    if (typeof QRCode !== 'undefined') {
                        try {
                            qrContainer.innerHTML = '';
                            new QRCode(qrContainer, {
                                text: qrText,
                                width: 160,
                                height: 160,
                                correctLevel: QRCode.CorrectLevel.L // menor correção para aumentar capacidade
                            });
                            // adiciona botão imprimir no modal (visível abaixo do QR)
                            const modalPrintBtn = document.createElement('button');
                            modalPrintBtn.type = 'button';
                            modalPrintBtn.className = 'btn btn-sm btn-outline-primary qr-print-btn';
                            modalPrintBtn.style.marginTop = '8px';
                            modalPrintBtn.textContent = 'Imprimir QR';
                            modalPrintBtn.addEventListener('click', function () {
                                if (window.imprimirQRCode) window.imprimirQRCode(qrContainer, info);
                            });
                            qrContainer.appendChild(modalPrintBtn);
                        } catch (e) {
                            console.error('Erro ao gerar QRCode:', e);
                            qrContainer.textContent = 'Erro ao gerar QR';
                        }
                    } else {
                        qrContainer.textContent = 'Biblioteca QRCode ausente';
                        console.warn('QRCode.js não encontrado. Importe a biblioteca antes deste script.');
                    }
                }
            }).then((result) => {
                // se usuário clicou em imprimir (deny)
                if (result.isDenied) {
                    const qrContainer = document.getElementById('swal-qr');
                    if (qrContainer && window.imprimirQRCode) {
                        window.imprimirQRCode(qrContainer, info);
                    } else {
                        alert('QR ou função de impressão não disponível.');
                    }
                }
            });
            return;
        }

        // fallback (insere célula se modal não disponível)
        if (typeof QRCode !== 'undefined') {
            if (tr.querySelector('.qr-cell')) return;
            const qrCell = tr.insertCell(-1);
            qrCell.className = 'qr-cell';
            const qrDiv = document.createElement('div');
            qrDiv.className = 'qr-code';
            qrCell.appendChild(qrDiv);
            try {
                new QRCode(qrDiv, { text: qrText, width: 100, height: 100, correctLevel: QRCode.CorrectLevel.L });
                tr.dataset.qrGenerated = '1';
            } catch (e) {
                console.error('Erro ao gerar QRCode no fallback:', e);
                qrDiv.textContent = 'QR erro';
            }
            return;
        }

        console.warn('Não foi possível gerar QR: SweetAlert2 e QRCode.js ausentes.');
    }

    // expõe globalmente para uso inline
    window.gerarQRCodeParaItem = gerarQRCodeParaItem;
})();

// expõe globalmente
window.gerarQRCodesParaItens = gerarQRCodesParaItens;