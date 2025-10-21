/*
    Este script gera QR Codes para cada item cadastrado.
    Supõe tabela com colunas: [0]=Nome, [1]=Número do Tombamento, [2]=Descrição, [3]=Unidade, [4]=Status, [5]=Data, [6]=Localização, [7]=Categoria
    Usa QRCode.js (carregado antes deste arquivo)
*/

function gerarQRCodesParaItens() {
    const tabela = document.getElementById('tabela-itens') || document.querySelector('table');
    if (!tabela) return;

    for (let i = 1; i < tabela.rows.length; i++) {
        const row = tabela.rows[i];
        if (row.dataset.qrGenerated === '1') continue;
        gerarQRCodeParaLinha(row);
    }
}

function gerarQRCodeParaLinha(row) {
    if (!row || row.dataset.qrGenerated === '1') return;

    const nome = (row.cells[0] && row.cells[0].innerText) ? row.cells[0].innerText.trim() : '';
    const numero_tombamento = (row.cells[1] && row.cells[1].innerText) ? row.cells[1].innerText.trim() : '';
    const descricao = (row.cells[2] && row.cells[2].innerText) ? row.cells[2].innerText.trim() : '';
    const unidade = (row.cells[3] && row.cells[3].innerText) ? row.cells[3].innerText.trim() : '';
    const status = (row.cells[4] && row.cells[4].innerText) ? row.cells[4].innerText.trim() : '';
    const dataAq = (row.cells[5] && row.cells[5].innerText) ? row.cells[5].innerText.trim() : '';
    const localizacao = (row.cells[6] && row.cells[6].innerText) ? row.cells[6].innerText.trim() : '';
    const categoria = (row.cells[7] && row.cells[7].innerText) ? row.cells[7].innerText.trim() : '';

    const info = `Número de Tombamento: ${numero_tombamento}\nNome: ${nome}\nDescrição: ${descricao}\nUnidade: ${unidade}\nStatus: ${status}\nData: ${dataAq}\nLocalização: ${localizacao}\nCategoria: ${categoria}`;

    // evita duplicar célula de QR
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
                confirmButtonText: 'Fechar',
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
                        } catch (e) {
                            console.error('Erro ao gerar QRCode:', e);
                            qrContainer.textContent = 'Erro ao gerar QR';
                        }
                    } else {
                        qrContainer.textContent = 'Biblioteca QRCode ausente';
                        console.warn('QRCode.js não encontrado. Importe a biblioteca antes deste script.');
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