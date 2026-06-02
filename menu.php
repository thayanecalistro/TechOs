<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard com Sidebar PHP</title>
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Ícones do Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Seu CSS Externo -->
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="d-flex" id="wrapper">
    
    <!-- Sidebar -->
    <div id="sidebar-wrapper">
        <div class="sidebar-heading fw-bold">Meu App PHP</div>
        
        <div class="list-group list-group-flush">
            <!-- Link Simples -->
            <a href="#" class="list-group-item list-group-item-action">
                <i class="bi bi-house-door me-2"></i> Início
            </a>

            <!-- Menu com Submenu 1 (Cadastros) -->
            <a href="#submenuCadastros" data-bs-toggle="collapse" class="list-group-item list-group-item-action dropdown-toggle">
                <i class="bi bi-pencil-square me-2"></i> Cadastros
            </a>
            <div class="collapse bg-dark" id="submenuCadastros">
                <a href="?page=clientes" class="list-group-item list-group-item-action ps-4 text-white-50">Clientes</a>
                <a href="?page=produtos" class="list-group-item list-group-item-action ps-4 text-white-50">Produtos</a>
            </div>

            <!-- Menu com Submenu 2 (Relatórios) -->
            <a href="#submenuRelatorios" data-bs-toggle="collapse" class="list-group-item list-group-item-action dropdown-toggle">
                <i class="bi bi-bar-chart-fill me-2"></i> Relatórios
            </a>
            <div class="collapse bg-dark" id="submenuRelatorios">
                <a href="?page=vendas" class="list-group-item list-group-item-action ps-4 text-white-50">Vendas Mensais</a>
                <a href="?page=estoque" class="list-group-item list-group-item-action ps-4 text-white-50">Giro de Estoque</a>
            </div>

            <!-- Outro Link Simples -->
            <a href="#" class="list-group-item list-group-item-action">
                <i class="bi bi-gear me-2"></i> Configurações
            </a>
        </div>
    </div>
    <!-- /Sidebar -->

    <!-- Conteúdo da Página -->
    <div id="page-content-wrapper" class="w-100">
        <!-- Navbar Superior com o botão de toggle -->
        <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom px-4 py-3">
            <button class="btn btn-outline-dark" id="menu-toggle">
                <i class="bi bi-list fs-5"></i>
            </button>
        </nav>

        <!-- Área Central Dinâmica em PHP -->
        <div class="container-fluid p-4">
            <?php
                // Um exemplo simples de como carregar as páginas dinamicamente no PHP
                $page = isset($_GET['page']) ? $_GET['page'] : 'home';
                
                switch ($page) {
                    case 'clientes':
                        echo "<h2>Gestão de Clientes</h2><p>Aqui você lista os clientes do banco de dados.</p>";
                        break;
                    case 'produtos':
                        echo "<h2>Lista de Produtos</h2><p>Gerencie seu estoque aqui.</p>";
                        break;
                    case 'vendas':
                        echo "<h2>Relatório de Vendas</h2><p>Gráficos e tabelas de faturamento.</p>";
                        break;
                    default:
                        echo "<h2>Bem-vindo ao Painel!</h2><p>Use o menu lateral para navegar pelo sistema.</p>";
                        break;
                }
            ?>
        </div>
    </div>
    <!-- /Conteúdo da Página -->

</div>

<!-- Bootstrap Bundle com Popper.js (Obrigatório para os submenus funcionarem) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Script simples para abrir/fechar a barra lateral -->
<script>
    const menuToggle = document.getElementById('menu-toggle');
    const wrapper = document.getElementById('wrapper');

    menuToggle.addEventListener('click', event => {
        event.preventDefault();
        wrapper.classList.toggle('toggled');
    });
</script>

</body>
</html>