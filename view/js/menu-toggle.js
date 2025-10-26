/* ===================================================
   CONTROLE DO MENU LATERAL RESPONSIVO
   ===================================================
   
   PROPÓSITO:
   - Gerencia abertura/fechamento do menu lateral
   - Persiste estado no localStorage do navegador
   - Comportamento diferente para desktop/mobile
   
   FUNCIONAMENTO:
   - Desktop: menu aberto por padrão
   - Mobile: menu fechado por padrão
   - Estado é lembrado entre sessões
   - Botões .menu-toggle controlam visibilidade
   
   CLASSES CSS UTILIZADAS:
   - .menu-toggle: botões que abrem/fecham menu
   - .open: classe que controla visibilidade do menu
   ===================================================
*/

/**
 * Inicializa o sistema de controle do menu lateral
 * Executa quando o DOM estiver completamente carregado
 */
document.addEventListener('DOMContentLoaded', function() {
    
    /* ========================================
       SELEÇÃO DE ELEMENTOS DO DOM
       ========================================
    */
    const menu = document.getElementById('menulocalizacao');        // Container do menu lateral
    const toggleButtons = document.querySelectorAll('.menu-toggle'); // Botões de toggle
    const body = document.body;                                     // Body para classes auxiliares
    
    console.log('Menu encontrado:', menu);
    console.log('Botões encontrados:', toggleButtons.length);
    
    // Sai se elementos essenciais não existirem
    if (!menu || !toggleButtons.length) return;
    
    
    /* ========================================
       RESTAURAÇÃO DO ESTADO SALVO
       ========================================
       Verifica localStorage para lembrar preferência do usuário
    */
    const stored = localStorage.getItem('menu-open');
    
    if (stored === '1') {
        // Usuário deixou menu aberto na última sessão
        menu.classList.add('open');
        body.classList.add('menu-open');
        
    } else if (stored === '0') {
        // Usuário deixou menu fechado na última sessão
        menu.classList.remove('open');
        body.classList.remove('menu-open');
        
    } else {
        /* COMPORTAMENTO PADRÃO (primeira visita)
           Desktop: menu aberto para facilitar navegação
           Mobile: menu fechado para não ocupar espaço */
        if (window.matchMedia('(min-width: 768px)').matches) {
            menu.classList.add('open');      // Desktop: aberto
            body.classList.add('menu-open');
        } else {
            menu.classList.remove('open');   // Mobile: fechado
            body.classList.remove('menu-open');
        }
    }
    
    
    /* ========================================
       CONFIGURAÇÃO DOS BOTÕES DE TOGGLE
       ========================================
       Adiciona evento de clique para todos os botões .menu-toggle
    */
    toggleButtons.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault(); // Evita comportamento padrão do botão
            
            // Toggle: adiciona .open se não tiver, remove se tiver
            const isOpen = menu.classList.toggle('open');
            
            // Adiciona classe no body para ajuste do layout
            if (isOpen) {
                body.classList.add('menu-open');
            } else {
                body.classList.remove('menu-open');
            }
            
            // PERSISTÊNCIA DO ESTADO
            // Salva preferência no localStorage para próximas sessões
            localStorage.setItem('menu-open', isOpen ? '1' : '0');
        });
    });
});
