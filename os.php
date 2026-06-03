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
    ]
];
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechOS - Menu</title>
    <style>
        /* Reset básico e Fontes */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* MODIFICADO: O body agora ocupa 100% da tela e distribui o conteúdo verticalmente */
        body {
            background-color: #243b55; /* Cor de fundo da antiga janela aplicada na tela toda */
            color: #ffffff;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            padding: 20px;
        }

        /* NOVO: Estrutura para alinhar o menu e o título na mesma linha no topo da tela */
        .header-container {
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            margin-bottom: 25px;
            width: 100%;
        }
        
        .header-menu {
            position: absolute;
            left: 0;
        }
        
        .btn-menu {
            background-color: #334e68;
            border: none;
            color: white;
            padding: 8px 12px;
            cursor: pointer;
            border-radius: 3px;
            font-size: 16px;
        }

        /* Título Principal */
        .main-title {
            text-align: center;
            font-family: 'Georgia', serif;
            font-size: 32px;
            font-weight: normal;
            letter-spacing: 1px;
        }

        /* Seção de Pesquisa - Agora expande na largura total */
        .search-fieldset {
            border: 1px solid #334e68;
            border-radius: 4px;
            padding: 15px;
            margin-bottom: 20px;
            width: 100%;
        }

        .search-fieldset legend {
            padding: 0 10px;
            font-size: 14px;
            color: #9fb3c8;
        }

        .search-box {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .search-box label {
            font-size: 14px;
        }

        .search-box input[type="text"] {
            background-color: #102a43;
            border: 1px solid #334e68;
            color: white;
            padding: 6px 10px;
            border-radius: 4px;
            width: 200px;
            outline: none;
        }

        /* Botões Gerais */
        .btn {
            padding: 6px 18px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            font-size: 14px;
            transition: background 0.2s;
        }

        .btn-blue { background-color: #486581; color: white; }
        .btn-blue:hover { background-color: #627d98; }

        .btn-cyan { background-color: #2cb1bc; color: #102a43; font-weight: 500; }
        .btn-cyan:hover { background-color: #4ed0dc; }

        .btn-red { background-color: #d9534f; color: white; }
        .btn-red:hover { background-color: #e66d6a; }

        .btn-light-blue { background-color: #3b82f6; color: white; }
        .btn-light-blue:hover { background-color: #60a5fa; }

        /* MODIFICADO: O container da tabela cresce para ocupar o espaço restante vertical */
        .table-container {
            border: 1px solid #486581;
            border-radius: 4px;
            background-color: #1a304a;
            overflow-x: auto;
            margin-bottom: 25px;
            width: 100%;
            flex-grow: 1; /* Faz a tabela ocupar o máximo de altura disponível */
        }

        /* Estilização da Tabela */
        .os-table {
            width: 100%;
            border-collapse: collapse;
            text-align: center;
            font-size: 13px;
        }

        .os-table th {
            background-color: #62b6cb;
            color: #102a43;
            padding: 10px;
            font-weight: 600;
        }

        .os-table td {
            padding: 10px;
            border-bottom: 1px solid #243b53;
        }

        /* Cores Alternadas das Linhas */
        .os-table tr:nth-child(odd) td {
            background-color: #3b4f66;
            color: #ffffff;
        }

        .os-table tr:nth-child(even) td {
            background-color: #fffbc8;
            color: #333333;
        }

        /* Rodapé com botões de ação */
        .footer-actions {
            display: flex;
            justify-content: center;
            gap: 15px;
            width: 100%;
            margin-top: auto; /* Garante que os botões fiquem sempre colados embaixo */
        }
    </style>
</head>
<body>

    <!-- Inclui o menu lateral estruturado -->
    <?php include('sidebar.php'); ?>

    <div class="header-container">
        <div class="header-menu">
            <button class="btn-menu" onclick="toggleSidebar(event)">☰</button>
        </div>
        <h1 class="main-title">Controle de Serviço</h1>
    </div>

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

</body>
</html>
