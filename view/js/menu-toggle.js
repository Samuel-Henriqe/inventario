document.addEventListener('DOMContentLoaded', function() {
  const menu = document.getElementById('menulocalizacao');
  const toggleButtons = document.querySelectorAll('.menu-toggle');

  if (!menu || !toggleButtons.length) return;

  // Restore state from localStorage
  const stored = localStorage.getItem('menu-open');
  if (stored === '1') {
    menu.classList.add('open');
  } else if (stored === '0') {
    menu.classList.remove('open');
  } else {
    // No preference saved: open by default on desktop, closed on mobile
    if (window.matchMedia('(min-width: 768px)').matches) {
      menu.classList.add('open');
    } else {
      menu.classList.remove('open');
    }
  }

  toggleButtons.forEach(btn => {
    btn.addEventListener('click', function(e) {
      e.preventDefault();
      const isOpen = menu.classList.toggle('open');
      localStorage.setItem('menu-open', isOpen ? '1' : '0');
    });
  });
});
