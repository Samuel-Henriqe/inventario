(function () {
    // Requer SweetAlert2 carregado antes deste arquivo (Swal)
    if (typeof Swal === 'undefined') {
        console.warn('SweetAlert2 não encontrado. Carregue https://cdn.jsdelivr.net/npm/sweetalert2@11 antes de alert-override.js');
    }

    // Substitui alert() por SweetAlert2 (mantém assinatura simples)
    window.alert = function (message) {
        var text = (typeof message === 'object') ? JSON.stringify(message) : String(message);
        // Retorna a Promise do Swal para quem quiser encadear
        return Swal.fire({
            icon: 'info',
            title: '',
            text: text,
            confirmButtonText: 'OK'
        });
    };

    // Função assíncrona para confirmar — retorna Promise<boolean>
    window.swalConfirm = function (message, title) {
        return Swal.fire({
            title: title || '',
            text: (typeof message === 'object') ? JSON.stringify(message) : String(message),
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Sim',
            cancelButtonText: 'Não'
        }).then(function (result) {
            return !!result.isConfirmed;
        });
    };

    // Substituto de prompt (retorna Promise<string|null>)
    window.swalPrompt = function (message, title, defaultValue) {
        return Swal.fire({
            title: title || '',
            text: (typeof message === 'object') ? JSON.stringify(message) : String(message),
            input: 'text',
            inputValue: defaultValue || '',
            showCancelButton: true,
            confirmButtonText: 'OK',
            cancelButtonText: 'Cancelar'
        }).then(function (result) {
            if (result.isConfirmed) return result.value;
            return null;
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