<!-- sidebar.php -->
<style>
    :root {
        --sidebar-bg: #343a40;
        --sidebar-hover: rgba(255, 255, 255, 0.1);
        --sidebar-active: #007bff;
        --text-color: #c2c7d0;
    }

    body {
        margin: 0;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        display: flex;
        background-color: #f4f6f9;
        color: #333;
        overflow-x: hidden;
    }

    /* Menu Lateral */
    .sidebar {
        width: 250px;
        min-width: 250px;
        height: 100vh;
        background-color: var(--sidebar-bg);
        color: var(--text-color);
        display: flex;
        flex-direction: column;
        position: fixed;
        left: -250px;
        top: 0;
        box-shadow: 0 14px 28px rgba(0,0,0,0.25);
        z-index: 1001;
        transition: left 0.3s ease;
    }

    .sidebar.active {
        left: 0;
    }

    /* Logo Brand */
    .sidebar-brand {
        padding: 15px;
        font-size: 18px;
        font-weight: 400;
        border-bottom: 1px solid #4b545c;
        display: flex;
        align-items: center;
        gap: 10px;
        color: #fff;
    }
    .brand-icon {
        background: #fff;
        color: var(--sidebar-bg);
        border-radius: 50%;
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
    }

    /* Perfil do Usuário */
    .sidebar-user {
        padding: 15px;
        display: flex;
        align-items: center;
        gap: 12px;
        border-bottom: 1px solid #4b545c;
    }
    .user-avatar {
        width: 35px;
        height: 35px;
        border-radius: 50%;
        background-color: #ccc;
        object-fit: cover;
    }
    .user-name {
        color: #fff;
        font-size: 14px;
    }

    /* Itens do Menu */
    .sidebar-menu {
        list-style: none;
        padding: 10px;
        margin: 0;
        overflow-y: auto;
        flex-grow: 1;
    }

    .menu-item a, .menu-dropdown-toggle {
        display: flex;
        align-items: center;
        padding: 10px 12px;
        color: var(--text-color);
        text-decoration: none;
        border-radius: 4px;
        font-size: 14px;
        margin-bottom: 5px;
        cursor: pointer;
        transition: background 0.2s, color 0.2s;
    }

    .menu-item a:hover, .menu-dropdown-toggle:hover {
        background-color: var(--sidebar-hover);
        color: #fff;
    }

    /* Item Ativo (Destaque igual ao AdminLTE da imagem) */
    .menu-item.active > a, .menu-item.active > .menu-dropdown-toggle {
        background-color: var(--sidebar-active);
        color: #fff;
    }

    .menu-item i {
        margin-right: 10px;
        width: 20px;
        text-align: center;
    }

    /* Seta do Submenu */
    .arrow {
        margin-left: auto;
        transition: transform 0.3s;
        border: solid var(--text-color);
        border-width: 0 2px 2px 0;
        display: inline-block;
        padding: 3px;
        transform: rotate(-45deg);
    }
    .menu-item.active .arrow {
        border-color: #fff;
    }
    .open .arrow {
        transform: rotate(45deg);
    }

    /* Submenu (Dropdown) */
    .submenu {
        list-style: none;
        padding-left: 20px;
        display: none;
    }
    .open .submenu {
        display: block;
    }
    .submenu a {
        font-size: 13px;
        padding: 8px 12px;
    }

    /* Área de Conteúdo da Página */
    .main-content {
        margin-left: 0px; /* Alinha o conteúdo ao lado do menu */
        padding: 20px;
        width: 100%;
        min-height: 100vh;
        transition: margin-left 0.3s ease;
    }
</style>

<!-- FontAwesome para os ícones idênticos aos da imagem do AdminLTE -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<div class="sidebar" id="sidebarMenu">
    <!-- Nome do Sistema / Logo -->
    <div class="sidebar-brand">
        <div class="brand-icon">A</div>
        <span>TechOS Admin</span>
    </div>

    <!-- Perfil do Usuário -->
    <div class="sidebar-user">
        <!-- Substitua pelo caminho real da imagem se tiver -->
        <img src="https://via.placeholder.com/150" alt="Avatar" class="user-avatar">
        <span class="user-name">Thay</span>
    </div>

    <!-- Links de Navegação -->
    <ul class="sidebar-menu">
        
        <!-- Dashboard (Primeira Tela) -->
        <li class="menu-item <?= ($currentPage == 'dashboard') ? 'active' : ''; ?>">
            <a href="dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
        </li>

        <!-- Ordem de Serviço -->
        <li class="menu-item <?= ($currentPage == 'os') ? 'active' : ''; ?>">
            <a href="os.php"><i class="fas fa-file-invoice"></i> Ordem de Serviço</a>
        </li>

        <!-- Orçamento -->
        <li class="menu-item <?= ($currentPage == 'orcamento') ? 'active' : ''; ?>">
            <a href="orcamentos.php"><i class="fas fa-calculator"></i> Orçamento</a>
        </li>

        <!-- Cliente com Submenu "Gerenciar" -->
        <li class="menu-item dropdown <?= ($currentPage == 'cliente') ? 'open active' : ''; ?>" id="clienteMenu">
            <div class="menu-dropdown-toggle" onclick="toggleDropdown()">
                <i class="fas fa-users"></i> Cliente
                <i class="arrow"></i>
            </div>
            <ul class="submenu">
                <li class="menu-item"><a href="gerenciar_clientes.php"><i class="far fa-circle"></i> Gerenciar</a></li>
            </ul>
            <ul class="submenu">
                <li class="menu-item"><a href="aparelho.php"><i class="fas fa-laptop"></i> Aparelho</a></li>
            </ul>
        </li>

        <!-- Funcionário -->
        <li class="menu-item <?= ($currentPage == 'funcionario') ? 'active' : ''; ?>">
            <a href="funcionario.php"><i class="fas fa-user-tie"></i> Funcionário</a>
        </li>

        <!-- Estoque -->
        <li class="menu-item <?= ($currentPage == 'estoque') ? 'active' : ''; ?>">
            <a href="estoque.php"><i class="fas fa-boxes"></i> Estoque</a>
        </li>

        <!-- Relatórios -->
        <li class="menu-item <?= ($currentPage == 'relatorios') ? 'active' : ''; ?>">
            <a href="relatorios.php"><i class="fas fa-chart-bar"></i> Relatórios</a>
        </li>

    </ul>
</div>

<script>
     // Abre/Fecha o submenu "Cliente"
    function toggleDropdown(event) {
        event.stopPropagation(); // Evita que feche o menu principal ao clicar aqui
        var dropdown = document.getElementById('clienteMenu');
        dropdown.classList.toggle('open');
    }

    // Função para abrir/fechar o menu completo lateral (Gatilho do botão hambúrguer)
    function toggleSidebar(event) {
        if(event) event.stopPropagation(); // Evita que o clique feche ele mesmo imediatamente
        var sidebar = document.getElementById('sidebarMenu');
        sidebar.classList.toggle('active');
    }

     // Fecha o menu lateral se clicar em qualquer outra parte da tela
     document.addEventListener('click', function(event) {
        var sidebar = document.getElementById('sidebarMenu');
        var btnMenu = document.querySelector('.btn-menu');
        
        // Se o menu estiver aberto, e o clique NÃO foi dentro da sidebar e NÃO foi no botão de abrir
        if (sidebar.classList.contains('active') && !sidebar.contains(event.target) && (!btnMenu || !btnMenu.contains(event.target))) {
            sidebar.classList.remove('active');
        }
    });
</script>