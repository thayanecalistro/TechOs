<?php

$currentPage = 'os';

// Simulação de dados vindo do banco de dados
$ordens_servico = [
    [
        "id" => 1,
        "abertura" => "2025-12-03 21:40:53",
        "fechamento" => "None",
        "cliente" => "João",
        "aparelho" => "Samsung A22",
        "status" => "aberto",
        "valor" => "200.00"
    ],
    [
        "id" => 2,
        "abertura" => "2025-12-03 21:42:15",
        "fechamento" => "None",
        "cliente" => "Luana",
        "aparelho" => "Apple 15",
        "status" => "aberto",
        "valor" => "430.00"
    ],
    [
        "id" => 3,
        "abertura" => "2025-12-03 21:42:15",
        "fechamento" => "None",
        "cliente" => "Vitor",
        "aparelho" => "Apple 16",
        "status" => "aberto",
        "valor" => "500.00"
    ]
];
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechOS - Menu</title>
    
    <link rel="stylesheet" href="css/ordemServico.css">

</head>
<body>

    <!-- Inclui o menu lateral estruturado -->
    <?php include('sidebar.php'); ?>

    <div class="page-content">
        
        <div class="os-header">
            <h2>Controle de OS</h2>
            <p>Aqui está o resumo do seu sistema hoje.</p>
        </div>


        <fieldset class="search-fieldset">
            <legend>Pesquisar</legend>
            <div class="search-box">
                <input type="text" id="pesquisar" name="pesquisar" placeholder="ID ou Nome do Cliente...">
                <button type="button" class="btn btn-blue" id="btnBuscar">Buscar</button>
                <select id="ordenarSelect" class="btn btn-cyan" style="color: #102a43; cursor: pointer; height: 31px; padding: 0 10px;">
                    <option value="" style="color: black;">Ordenar</option>
                    <option value="id" style="color: black;">ID</option>
                    <option value="nome" style="color: black;">Nome (Cliente)</option>
                </select>
            </div>
        </fieldset>

        <div class="footer-actions">
            <button type="button" class="btn btn-red" id="btnExcluir">Excluir</button>
            <button type="button" class="btn btn-light-blue" onclick="window.location.reload();">Atualizar Tabela</button>
        </div>

        <div class="table-container">
            <table class="os-table" id="osTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Abertura</th>
                        <th>Fechamento</th>
                        <th>Cliente</th>
                        <th>Aparelho</th>
                        <th>Status</th>
                        <th>Valor (R$)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($ordens_servico as $os): ?>
                        <tr>
                            <td><?= $os['id']; ?></td>
                            <td><?= $os['abertura']; ?></td>
                            <td><?= $os['fechamento']; ?></td>
                            <td><?= $os['cliente']; ?></td>
                            <td><?= $os['aparelho']; ?></td>
                            <td><?= $os['status']; ?></td>
                            <td><?= $os['valor']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal-overlay" id="confirmModal">
        <div class="modal-content">
            <h3>Confirmação de Exclusão</h3>
            <p id="modalMessage">Tem certeza que deseja excluir o item selecionado?</p>
            <div class="modal-buttons">
                <button type="button" class="btn btn-red" id="confirmDelete">Sim, Excluir</button>
                <button type="button" class="btn btn-blue" id="cancelDelete">Cancelar</button>
            </div>
        </div>
    </div>

    <script src="js/os.js"></script>

</body>
</html>
