function toggleDropdown(e) {
    // Se o menu estiver colapsado, não abre o dropdown para evitar quebrar o layout
    if(document.getElementById('mySidebar').classList.contains('collapsed')) return;
    
    var dropdown = document.getElementById('clienteMenu');
    dropdown.classList.toggle('open');
}

function toggleSidebar() {
    const sidebar = document.getElementById('mySidebar');
    const body = document.body;
    
    sidebar.classList.toggle('collapsed');
    body.classList.toggle('collapsed');
    
    // Guarda a preferência do usuário
    const isCollapsed = sidebar.classList.contains('collapsed');
    localStorage.setItem('sidebarCollapsed', isCollapsed);
}

// Mantém o estado do menu ao recarregar a página
document.addEventListener("DOMContentLoaded", function() {
    if (localStorage.getItem('sidebarCollapsed') === 'true') {
        const sidebar = document.getElementById('mySidebar');
        const body = document.body;

        if(sidebar && body){
            sidebar.classList.add('collapsed');
            body.classList.add('collapsed');
        }
    }
});