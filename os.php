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
    
    <link rel="stylesheet" href="../css/os.css">
</head>
<body>

    <!-- Inclui o menu lateral estruturado -->
    <?php include('sidebar.php'); ?>

    <div class="page-content">

            <h1 class="main-title">Controle de Serviço</h1>

        <fieldset class="search-fieldset">
            <legend>Pesquisar Aparelho</legend>
            <div class="search-box">
                <label for="pesquisar">Pesquisar:</label>
                <input type="text" id="pesquisar" name="pesquisar">
                <button class="btn btn-blue">Buscar</button>
                <button class="btn btn-cyan">Ordenar</button>
            </div>
        </fieldset>

        <div class="table-container">
            <table class="os-table">
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

        <div class="footer-actions">
            <button class="btn btn-red">Excluir</button>
            <button class="btn btn-light-blue">Atualizar Tabela</button>
        </div>

    </div>

</body>
</html>
