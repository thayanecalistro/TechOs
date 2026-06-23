<?php

include("php/funcoes.php");

$currentPage = 'orcamento';

// Lógica PHP para calcular o total dinamicamente com base nos dados informados
$valor_peca = isset($_POST['valorUni']) ? floatval($_POST['valorUni']) : 0;
$qtd_peca = isset($_POST['qtd']) ? intval($_POST['qtd']) : 1;
$mao_obra = isset($_POST['maoObra']) ? floatval($_POST['maoObra']) : 0;

// Cálculo do Total: (Valor da Peça * Quantidade) + Mão de Obra
$total_orcamento = ($valor_peca * $qtd_peca) + $mao_obra;
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Orcamento</title>
        <meta charset="UTF-8">
    
        <link rel="stylesheet" href="css/orcamento.css">
    </head>

    <body>

        <!-- Inclui o menu lateral estruturado -->
        <?php include('sidebar.php'); ?>

        <div class="page-content">

            <div class="orcamento-header">
            <h2>Orcamentos</h2>
                <button id="btnAbrirNovo" class="btn-sucesso">Novo</button>
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

        

        <div class="section-card">

            <div class="table-container">
                <table class="orcamento-table" id="orcamentoTable">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Cliente</th>
                            <th scope="col">Aparelho</th>
                            <th scope="col">Peça</th>
                            <th scope="col">Valor Unitário</th>
                            <th scope="col">Mão de Obra</th>
                            <th scope="col">Total(R$)</th>
                            <th scope="col">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                      <!-- ?php echo listaOrcamento(); ?>-->
                      <tr>
                            <td>2</td>
                            <td>Jacob</td>
                            <td>Xiaomi</td>
                            <td>Bateria</td>
                            <td>69,99</td>
                            <td>50,00</td>
                            <td>119,99</td>
                            <td>Aberto</td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Otto</td>
                            <td>Samsung</td>
                            <td>Tela</td>
                            <td>20,99</td>
                            <td>50,00</td>
                            <td>70,99</td>
                            <td><span class=" badge badge-aprovado">APROVADO</span></td>
                        </tr>
                        <tr class="table-success-custom">
                            <td>8</td>
                            <td>Luana</td>
                            <td>Apple 15</td>
                            <td>tela Iphone 15</td>
                            <td>R$ 350.00</td>
                            <td>R$ 80.00</td>
                            <td>R$ 430.00</td>
                            <td><span class=" badge badge-aprovado">APROVADO</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </body>
</html>
