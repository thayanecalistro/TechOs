<link rel= "stylesheet" href="css/sidebar.css">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<div class="sidebar" id="mySidebar">
    <div class="sidebar-header">
        <button class="btn-toggle-menu" onclick="toggleSidebar()">
            <i class="fas fa-bars"></i>
        </button>
    </div>

    <div class="sidebar-brand" style="display: flex; align-items: center; gap: 10px; padding: 15px;">
        <div class="brand-icon">
            <img src="img/techOs.png" alt="Logo TechOS" style="width: 35px !important; height: 35px !important; object-fit: contain !important; display: block;">
        </div>
        <span style="font-size: 1.1rem; font-weight: bold; color: #62b6cb; white-space: nowrap;">TECH OS</span>
    </div>
    

    <!--<div class="sidebar-user">
        <div class="image">
          <img src=" echo fotoUsuario($_SESSION['idFuncionario']); ?>" alt="Avatar" class="user-avatar">
        </div>
        <div class="info">
          <a href="#" class="d-block"> echo nomeUsuario($_SESSION['idFuncionario']); ?></a>
        </div>
    </div>-->

    <ul class="sidebar-menu">
        <li class="menu-item <?= ($currentPage == 'dashboard') ? 'active' : ''; ?>">
            <a href="dashboard.php"><i class="fas fa-tachometer-alt"></i> <span>Dashboard</span></a>
        </li>

        <li class="menu-item <?= ($currentPage == 'os') ? 'active' : ''; ?>">
            <a href="os.php"><i class="fas fa-file-invoice"></i> <span>Ordem de Serviço</span></a>
        </li>

        <li class="menu-item <?= ($currentPage == 'orcamento') ? 'active' : ''; ?>">
            <a href="orcamentos.php"><i class="fas fa-calculator"></i> <span>Orçamento</span></a>
        </li>

        <li class="menu-item <?= ($currentPage == 'cliente') ? 'active' : ''; ?>">
            <a href="cliente.php"><i class="fas fa-users"></i> <span>Cliente</span></a>
        </li>

    <!--<li class="menu-item dropdown = ($currentPage == 'cliente') ? 'open active' : ''; ?>" id="clienteMenu">
            <div class="menu-dropdown-toggle" onclick="toggleDropdown(event)">
                <i class="fas fa-users"></i> <span>Cliente</span>
                <i class="arrow"></i>
            </div>
            <ul class="submenu">
                <li class="menu-item"><a href="cadastroCliente.php"><i class="far fa-circle"></i> <span>Gerenciar</span></a></li>
            </ul>
        </li>-->

        <li class="menu-item <?= ($currentPage == 'aparelho') ? 'active' : ''; ?>">
            <a href="cadastroAparelho.php"><i class="fas fa-laptop"></i> <span>Aparelho</span></a>
        </li>

        <li class="menu-item <?= ($currentPage == 'funcionario') ? 'active' : ''; ?>">
<<<<<<< HEAD
            <a href="cadastroFuncionario.php"><i class="fas fa-user-tie"></i> <span>Colaboradores</span></a>
=======
            <a href="funcionarios.php"><i class="fas fa-user-tie"></i> <span>Funcionário</span></a>
>>>>>>> f38372e0b639dd02a0bd5748fc010b7d91742171
        </li>

        <li class="menu-item <?= ($currentPage == 'estoque') ? 'active' : ''; ?>">
            <a href="estoque.php"><i class="fas fa-boxes"></i> <span>Estoque</span></a>
        </li>

        <li class="menu-item <?= ($currentPage == 'relatorios') ? 'active' : ''; ?>">
            <a href="relatorio.php"><i class="fas fa-chart-bar"></i> <span>Relatórios</span></a>
        </li>
    </ul>

    <div class="sidebar-footer">
        <button class="btn-logout" onclick="window.location.href='index.php'">
            <i class="fas fa-sign-out-alt"></i> <span>Sair</span>
        </button>
    </div>
</div>

<script src="js/sidebar.js"></script>
