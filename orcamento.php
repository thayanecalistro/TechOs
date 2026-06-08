<?php

$currentPage = 'orcamento';

// Lógica PHP para calcular o total dinamicamente com base nos dados informados
$valor_peca = isset($_POST['valor_peca']) ? floatval($_POST['valor_peca']) : 0;
$qtd_peca = isset($_POST['qtd']) ? intval($_POST['qtd']) : 1;
$mao_obra = isset($_POST['mao_obra']) ? floatval($_POST['mao_obra']) : 0;

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
                
                <form method="POST" action="">
                    <fieldset>
                        <legend>Novo Orçamento</legend>

                        <div class="grid-form">
                            <div class="col-4">
                                <label class="form-label">Cliente:</label>
                                <input type="text" list="lista-clientes" id="cliente" name="cliente" class="form-control" 
                                    placeholder="Carregando clientes..." value="<?php echo isset($_POST['cliente']) ? htmlspecialchars($_POST['cliente']) : ''; ?>">
                                <datalist id="lista-clientes">
                                    </datalist>
                            </div>
                            <div class="col-4">
                                <label class="form-label">Aparelho:</label>
                                <input type="text" list="lista-aparelhos" id="aparelho" name="aparelho" class="form-control"
                                    placeholder="Carregando clientes..." value="<?php echo isset($_POST['aparelho']) ? htmlspecialchars($_POST['aparelho']) : ''; ?>">
                                <datalist id="lista-aparelhos">
                                    </datalist>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Diagnóstico:</label>
                                <input type="text" name="diagnostico" class="form-control" value="<?php echo isset($_POST['diagnostico']) ? htmlspecialchars($_POST['diagnostico']) : ''; ?>">
                            </div>
                            <div class="col-6">
                                <label class="form-label">Peça necessária:</label>
                                <select class="form-select" id="peca" name="peca">
                                    <option selected>Selecione...</option>
                                    <option value="Tela" <?php echo (isset($_POST['peca']) && $_POST['peca'] == 'Tela') ? 'selected' : ''; ?>>Tela</option>
                                    <option value="Bateria" <?php echo (isset($_POST['peca']) && $_POST['peca'] == 'Bateria') ? 'selected' : ''; ?>>Bateria</option>
                                </select>
                            </div>
                            <div class="col-4">
                                <label class="form-label">Valor Peça (R$):</label>
                                <input type="number" step="0.01" name="valor_peca" class="form-control" placeholder="0.00" value="<?php echo isset($_POST['valor_peca']) ? htmlspecialchars($_POST['valor_peca']) : ''; ?>">
                            </div>
                            <div class="col-2">
                                <label class="form-label">Qtd:</label>
                                <input type="number" name="qtd" class="form-control" value="<?php echo isset($_POST['qtd']) ? htmlspecialchars($_POST['qtd']) : '1'; ?>">
                            </div>
        
                            <div class="col-12">
                                <button type="button" class="btn btn-blue btn-sm">+ Peça</button>
                            </div>
        
                            <div class="col-4">
                                <label class="form-label">Mão de Obra (R$):</label>
                                <input type="number" step="0.01" name="mao_obra" class="form-control" placeholder="0.00" value="<?php echo isset($_POST['mao_obra']) ? htmlspecialchars($_POST['mao_obra']) : ''; ?>">
                            </div>
                            <div class="col-4">
                                <label class="form-label">Status:</label>
                                <select class="form-select" id="status" name="status">
                                    <option value="aberto" <?php echo (isset($_POST['status']) && $_POST['status'] == 'aberto') ? 'selected' : ''; ?>>Aberto</option>
                                    <option value="aprovado" <?php echo (isset($_POST['status']) && $_POST['status'] == 'aprovado') ? 'selected' : ''; ?>>Aprovado</option>
                                    <option value="recusado" <?php echo (isset($_POST['status']) && $_POST['status'] == 'recusado') ? 'selected' : ''; ?>>Recusado</option>
                                </select>
                            </div>

                        </div>
                        <br>
                        <div class="mt-4">
                            <button type="submit" class="btn btn-success">Salvar</button>
                            <button type="button" class="btn btn-warning">Editar</button>
                            <button type="button" class="btn btn-danger">Excluir</button>
                        </div>
                        <br>
                        <label class="total-label">Total: R$ <?php echo number_format($total_orcamento, 2, ',', '.'); ?></label>
                    </fieldset>
                </form>
                <br><br>
                <div class="table-section">
                    
                        <div class="search-container">
                            <input type="text" class="form-control search-input" placeholder="Pesquisar...">
                            <button class="btn btn-blue search-btn">Buscar</button>
                        </div>
                    
                    <br>
                    <div class="table-container"> 
                        <table  border= "1" class=" orcamento-table" >
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
                            <tr>
                                <th scope="row">1</th>
                                <td>Mark</td>
                                <td>Iphone</td>
                                <td>Tela</td>
                                <td>25,50</td>
                                <td>50,00</td>
                                <td>75,50</td>
                                <td>Aberto</td>
                            </tr>
                            <tr>
                                <th scope="row">2</th>
                                <td>Jacob</td>
                                <td>Xiaomi</td>
                                <td>Bateria</td>
                                <td>69,99</td>
                                <td>50,00</td>
                                <td>119,99</td>
                                <td>Aberto</td>
                            </tr>
                            <tr>
                                <th scope="row">3</th>
                                <td>Otto</td>
                                <td>Samsung</td>
                                <td>Tela</td>
                                <td>20,99</td>
                                <td>50,00</td>
                                <td>70,99</td>
                                <td>Aprovado</td>
                            </tr>
                            <tr class="table-success-custom">
                                <th scope="row">8</th>
                                <td>Luana</td>
                                <td>Apple 15</td>
                                <td>tela Iphone 15</td>
                                <td>R$ 350.00</td>
                                <td>R$ 80.00</td>
                                <td>R$ 430.00</td>
                                <td><span class=" badge badge-aprovado">APROVADO</span></td>
                            </tr>
                            <!--EXEMPLO DE UMA LINHA SÓ---------------------
                                <tr class="table-success text-dark">
                                    <td>8</td>
                                    <td>Luana</td>
                                    <td>Apple 15</td>
                                    <td>tela Iphone 15</td>
                                    <td>R$ 350.00</td>
                                    <td>R$ 80.00</td>
                                    <td>R$ 430.00</td>
                                    <td>APROVADO</td>
                                </tr>-->
                            </tbody>
                        </table>
                    </div>
                    
                </div>
        </div>
    </body>
</html>
