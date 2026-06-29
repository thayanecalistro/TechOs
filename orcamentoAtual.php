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

            <div class="table-section">
                
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
                        <table class=" orcamento-table" >
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
                            <?php echo listaOrcamento(); ?>
                            </tbody>
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
                        </table>
                    </div>
                </div>
            </div>

            <div id="meuModal" class="modal">
                <div class="modal-conteudo">
                    <span class="botaoFechar">&times;</span>
                        <h2>Novo Orçamento</h2>

                    <form method="POST" action="php/salvarOrcamneto.php?opcao=I">

                        <div class="linhaFormulario">
                            <input type="text" placeholder="Nome do cliente" name="nNome">

                            <input type="text" placeholder="Aparelho do cliente" name="nAparelho">
                        </div>

                        <div class="linhaFormulario">
                            <input type="text" placeholder="Diagnóstico" name="nTelefone">
                        </div>

                        <div class="linhaFormulario">
                            <input type="text" placeholder="Peça necessária" name="nPeça">
                            <input type="text" placeholder="Valor Peça (R$):" name="nValorUni">
                            <input type="text" placeholder="Qtd:" name="nQtd">
                        </div>

                        <div class="linhaFormulario">
                            <button type="button" class="btn btn-blue btn-sm">+ Peça</button> 
                        </div>

                        <div class="linhaFormulario">
                            <input type="text" placeholder="Mão de Obra (R$):" name="nMaoObra">
                        </div>

                        <div class="linhaFormulario">
                            <label class="form-label">Status:</label>
                                <select class="form-select" id="status" name="status">
                                    <option value="aberto" ?php echo (isset($_POST['status']) && $_POST['status'] == 'aberto') ? 'selected' : ''; ?>>Aberto</option>
                                    <option value="aprovado" ?php echo (isset($_POST['status']) && $_POST['status'] == 'aprovado') ? 'selected' : ''; ?>>Aprovado</option>
                                    <option value="recusado" ?php echo (isset($_POST['status']) && $_POST['status'] == 'recusado') ? 'selected' : ''; ?>>Recusado</option>
                                </select>                     
                        </div>

                        <div class="linhaFormulario">
                            <label class="total-label">Total: R$ ?php echo number_format($total_orcamento, 2, ',', '.'); ?></label>
                        </div>

                        <div class="botaoContainer"> <input type="submit" value="Salvar" id="botaoSalvar" ></div>

                    </form>

                </div>
            </div>
        </div>
    </body>
</html>
