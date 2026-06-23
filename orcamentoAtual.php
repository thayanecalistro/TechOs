<?php
include("php/funcoes.php");
$currentPage = 'orcamento';

$valor_peca = isset($_POST['valor_peca']) ? floatval($_POST['valor_peca']) : 0;
$qtd_peca = isset($_POST['qtd']) ? intval($_POST['qtd']) : 1;
$mao_obra = isset($_POST['mao_obra']) ? floatval($_POST['mao_obra']) : 0;
$total_orcamento = ($valor_peca * $qtd_peca) + $mao_obra;
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Orcamento</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="css/orcamento.css">
        <style>
            dialog::backdrop { background: rgba(0, 0, 0, 0.6); }
            dialog { border: none; border-radius: 8px; padding: 20px; background: #1a304a; color: white; text-align: center; }
            dialog button { margin-top: 15px; }
        </style>
    </head>
    <body>

        <?php include('sidebar.php'); ?>

        <div class="page-content">

            <div class="header-table-section">
                <button id="btnAbrirNovo" class="btn-sucesso">Novo Orçamento</button>
            </div>
               
                <form method="POST" action="" id="form-orcamento">
                    <fieldset>
                        <legend>Novo Orçamento</legend>

                        <div class="grid-form">
                            <div class="col-4">
                                <label class="form-label">Cliente:</label>
                                <input type="text" list="lista-clientes" id="cliente" class="form-control" placeholder="Comece a digitar o nome..." autocomplete="off">
                                <input type="hidden" name="Cliente_idCliente" id="cliente_id_hidden">
                                <datalist id="lista-clientes"></datalist>
                            </div>

                            <div class="col-4">
                                <label class="form-label">Aparelho:</label>
                                <select id="aparelho" name="Aparelho_idAparelho" class="form-select">
                                    <option value="" selected disabled>Selecione um cliente primeiro...</option>
                                </select>
                            </div>

                            <div class="col-12">
                                <label class="form-label">Diagnóstico:</label>
                                <input type="text" name="diagnostico" class="form-control">
                            </div>

                            <div class="col-12 grid-form" id="container-pecas" style="padding:0; gap:1rem;">
                                <div class="peca-row grid-form col-12" style="padding:0; gap:1rem; display:flex;">
                                    <div class="col-6">
                                        <label class="form-label">Peça necessária:</label>
                                        <input type="text" list="lista-pecas" name="peca[]" class="form-control input-peca" placeholder="Digite o nome da peça..." autocomplete="off">
                                    </div>
                                    <div class="col-4">
                                        <label class="form-label">Valor Peça (R$):</label>
                                        <input type="number" step="0.01" name="valor_peca[]" class="form-control input-valor-peca" placeholder="0.00">
                                    </div>
                                    <div class="col-2">
                                        <label class="form-label">Qtd:</label>
                                        <input type="number" name="qtd[]" class="form-control input-qtd-peca" value="1">
                                    </div>
                                </div>
                            </div>

                            <datalist id="lista-pecas"></datalist>
       
                            <div class="col-12">
                                <button type="button" id="btn-add-peca" class="btn btn-blue btn-sm">+ Peça</button>
                            </div>
       
                            <div class="col-4">
                                <label class="form-label">Mão de Obra (R$):</label>
                                <input type="number" step="0.01" id="mao_obra" name="mao_obra" class="form-control" placeholder="0.00">
                            </div>

                            <div class="col-4">
                                <label class="form-label">Status:</label>
                                <select class="form-select" id="status" name="status" disabled>
                                    <option value="aberto" selected>Aberto</option>
                                    <option value="aprovado">Aprovado</option>
                                    <option value="reprovado">Reprovado</option>
                                </select>
                                <input type="hidden" id="status_hidden" name="status" value="aberto">
                            </div>

                        </div>
                        <br>
                        <div class="mt-4">
                            <button type="submit" class="btn btn-success">Salvar</button>
                            <button type="button" id="btn-editar" class="btn btn-warning">Editar</button>
                            <button type="button" class="btn btn-danger">Excluir</button>
                        </div>
                        <br>
                        <label class="total-label" id="label-total">Total: R$ 0,00</label>
                    </fieldset>
                </form>
                <br><br>

                

                <div class="table-section">
                <div class="search-container">
                        <input type="text" id="input-busca" class="form-control search-input" placeholder="Pesquisar por Cliente ou ID...">
                        <button type="button" id="btn-busca" class="btn btn-blue search-btn">Buscar</button>
                    </div>
                   
                    <br>
                    <div class="table-container">
                        <table border="1" class="orcamento-table">
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
                            <tbody id="corpo-tabela">
                                <?php echo listaOrcamento(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
        </div>

        <dialog id="modal-aviso">
            <h3>Aviso do Sistema</h3>
            <p>Novos orçamentos são registrados obrigatoriamente com o status inicial <strong>Aberto</strong>.</p>
            <button class="btn btn-blue" onclick="document.getElementById('modal-aviso').close()">Ok</button>
        </dialog>

        <script src="js/orcamento.js"></script>
        
    </body>
</html>