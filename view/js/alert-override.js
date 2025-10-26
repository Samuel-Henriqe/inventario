/* ===================================================
   SUBSTITUÇÃO DE ALERTAS NATIVOS POR SWEETALERT2
   ===================================================
   
   PROPÓSITO:
   - Substitui alert(), confirm() e prompt() nativos do navegador
   - Oferece interface mais bonita e consistente
   - Mantém compatibilidade com código existente
   
   DEPENDÊNCIAS:
   - SweetAlert2 deve estar carregado antes deste arquivo
   - CDN: https://cdn.jsdelivr.net/npm/sweetalert2@11
   
   FUNÇÕES DISPONÍVEIS:
   - window.alert() - sobrescreve alert nativo
   - window.swalConfirm() - confirmação assíncrona
   - window.swalPrompt() - input assíncrono
   
   IMPORTANTE:
   As versões SweetAlert são assíncronas (retornam Promise)
   ===================================================
*/

(function () {
    
    /* ========================================
       VERIFICAÇÃO DE DEPENDÊNCIAS
       ========================================
    */
    if (typeof Swal === 'undefined') {
        console.warn('SweetAlert2 não encontrado. Carregue https://cdn.jsdelivr.net/npm/sweetalert2@11 antes de alert-override.js');
        return; // Sai se SweetAlert2 não estiver disponível
    }
    
    
    /* ========================================
       SOBRESCRITA DO ALERT NATIVO
       ========================================
       Substitui window.alert() por versão SweetAlert2
    */
    
    /**
     * Substitui alert() nativo por SweetAlert2
     * 
     * @param {string|object} message - Mensagem a ser exibida
     * @returns {Promise} Promise do SweetAlert2 para encadeamento
     * 
     * DIFERENÇAS DO NATIVO:
     * - Visual mais bonito e customizável
     * - Retorna Promise (assíncrono)
     * - Funciona com objetos (converte para JSON)
     */
    window.alert = function (message) {
        // Converte objetos para string JSON, outros tipos para string
        var text = (typeof message === 'object') ? JSON.stringify(message) : String(message);
        
        return Swal.fire({
            icon: 'info',              // Ícone informativo
            title: '',                 // Sem título para manter simplicidade
            text: text,                // Mensagem convertida
            confirmButtonText: 'OK'    // Texto do botão
        });
    };
    
    
    /* ========================================
       FUNÇÃO DE CONFIRMAÇÃO ASSÍNCRONA
       ========================================
       Substituto mais robusto para confirm()
    */
    
    /**
     * Exibe diálogo de confirmação com SweetAlert2
     * 
     * @param {string|object} message - Mensagem da confirmação
     * @param {string} title - Título opcional do modal
     * @returns {Promise<boolean>} true se confirmou, false se cancelou
     * 
     * USO:
     * swalConfirm('Deseja excluir?', 'Confirmar').then(result => {
     *     if (result) { // usuário clicou "Sim" }
     * });
     */
    window.swalConfirm = function (message, title) {
        return Swal.fire({
            title: title || '',                              // Título opcional
            text: (typeof message === 'object') ? JSON.stringify(message) : String(message),
            icon: 'question',                               // Ícone de pergunta
            showCancelButton: true,                         // Mostra botão cancelar
            confirmButtonText: 'Sim',                       // Texto confirmação
            cancelButtonText: 'Não'                        // Texto cancelar
        }).then(function (result) {
            return !!result.isConfirmed;                    // Converte para boolean
        });
    };
    
    
    /* ========================================
       FUNÇÃO DE INPUT ASSÍNCRONA
       ========================================
       Substituto mais robusto para prompt()
    */
    
    /**
     * Exibe diálogo de input com SweetAlert2
     * 
     * @param {string|object} message - Mensagem do input
     * @param {string} title - Título opcional do modal
     * @param {string} defaultValue - Valor padrão do campo
     * @returns {Promise<string|null>} string digitada ou null se cancelou
     * 
     * USO:
     * swalPrompt('Digite seu nome:', 'Cadastro').then(nome => {
     *     if (nome) { // usuário digitou algo }
     * });
     */
    window.swalPrompt = function (message, title, defaultValue) {
        return Swal.fire({
            title: title || '',                             // Título opcional
            text: (typeof message === 'object') ? JSON.stringify(message) : String(message),
            input: 'text',                                  // Tipo de input
            inputValue: defaultValue || '',                 // Valor inicial
            showCancelButton: true,                         // Mostra botão cancelar
            confirmButtonText: 'OK',                        // Texto confirmação
            cancelButtonText: 'Cancelar'                   // Texto cancelar
        }).then(function (result) {
            if (result.isConfirmed) return result.value;   // Retorna valor digitado
            return null;                                    // Retorna null se cancelou
        });
    };

    // AVISO: não é possível replicar o comportamento síncrono de window.confirm/prompt.
    // Substituímos window.confirm e window.prompt por versões que retornam Promise.
    window.confirm = function (message) {
        console.warn('window.confirm() foi sobrescrito por uma versão assíncrona. Use await swalConfirm(...) ou .then(...)');
        return window.swalConfirm(message);
    };

    window.prompt = function (message, defaultValue) {
        console.warn('window.prompt() foi sobrescrito por uma versão assíncrona. Use await swalPrompt(...) ou .then(...)');
        return window.swalPrompt(message, '', defaultValue);
    };

    // Helpers de sucesso/erro rápidos
    window.showSuccess = function (text, title) {
        return Swal.fire({ icon: 'success', title: title || '', text: text || '', confirmButtonText: 'OK' });
    };
    window.showError = function (text, title) {
        return Swal.fire({ icon: 'error', title: title || 'Erro', text: text || '', confirmButtonText: 'OK' });
    };
})();