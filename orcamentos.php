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
    
        <style>
            /* --- REGRAS DO SEU LAYOUT ORIGINAL --- */
            body { 
                background-color: #2c3e50; 
                color: white; 
                font-family: sans-serif;
                margin: 0;
                padding: 0;
            } 
            .sidebar { 
                background-color: #34495e; 
                min-height: 100vh; 
                padding: 20px; 
            }
            .main-card { 
                border: 1px solid #3498db; 
                padding: 20px; 
                border-radius: 5px; 
                margin-top: 20px; 
                background-color: rgba(0,0,0,0.1);
            }
            .form-label { 
                margin-bottom: 2px; 
                font-size: 0.9rem; 
                display: block;
            }
            .form-control, .form-select {
                background-color: #34495e;
                border: 1px solid #5d6d7e;
                color: white;
                width: 100%;
                padding: 6px 12px;
                border-radius: 4px;
                box-sizing: border-box;
            }
            .form-control:focus, .form-select:focus { 
                background-color: #3e5871; 
                color: white; 
                border-color: #3498db; 
                outline: none;
            }
            .total-label { 
                font-size: 1.2rem; 
                font-weight: bold; 
                margin-top: 15px; 
                display: block; 
            }
            legend { 
                width: auto; 
                padding: 0 10px; 
                font-size: 1.1rem; 
                color: #3498db; 
                border: none; 
            }
            fieldset { 
                border: 1px solid #3498db !important; 
                padding: 15px !important; 
                border-radius: 8px; 
                margin-bottom: 20px;
            }

            /* --- SUBSTITUIÇÃO DO BOOTSTRAP POR CSS PURO (Mantendo as proporções) --- */
            .container-fluid {
                width: 100%;
                padding-right: 15px;
                padding-left: 15px;
                margin-right: auto;
                margin-left: auto;
                box-sizing: border-box;
            }
            .p-4 { padding: 1.5rem !important; }
            .mt-4 { margin-top: 1.5rem !important; }
            .mt-5 { margin-top: 3rem !important; }
            .mb-3 { margin-bottom: 1rem !important; }

            /* Grid do Formulário (Substitui o row g-3 do Bootstrap) */
            .grid-form {
                display: grid;
                grid-template-columns: repeat(12, 1fr);
                gap: 1rem;
            }
            .col-4 { grid-column: span 4; }
            .col-6 { grid-column: span 6; }
            .col-2 { grid-column: span 2; }
            .col-12 { grid-column: span 12; }

            /* Responsividade simples para telas menores */
            @media (max-width: 768px) {
                .col-4, .col-6, .col-2 { grid-column: span 12; }
            }

            /* Estilização Manual dos Botões */
            .btn {
                display: inline-block;
                font-weight: 400;
                text-align: center;
                vertical-align: middle;
                cursor: pointer;
                border: 1px solid transparent;
                padding: 6px 12px;
                font-size: 1rem;
                border-radius: 4px;
                color: white;
                text-decoration: none;
                margin-right: 5px;
            }
            .btn-sm { padding: 4px 8px; font-size: 0.875rem; }
            .btn-primary { background-color: #3498db; border-color: #3498db; }
            .btn-success { background-color: #2ecc71; border-color: #2ecc71; }
            .btn-warning { background-color: #f1c40f; border-color: #f1c40f; color: #2c3e50; }
            .btn-danger { background-color: #e74c3c; border-color: #e74c3c; }

            /* Grupo de entrada da pesquisa */
            .input-group {
                display: flex;
                width: 100%;
            }
            .input-group .form-control {
                border-top-right-radius: 0;
                border-bottom-right-radius: 0;
            }
            .input-group .btn {
                border-top-left-radius: 0;
                border-bottom-left-radius: 0;
                margin-right: 0;
            }

            /* Estilos da Tabela (Mantendo o visual Dark que você configurou) */
            .table {
                width: 100%;
                margin-bottom: 1rem;
                color: #fff;
                border-collapse: collapse;
            }
            .table-bordered th, .table-bordered td {
                border: 1px solid #5d6d7e;
                padding: 8px;
                text-align: left;
            }
            .table-hover tbody tr:hover {
                background-color: rgba(255, 255, 255, 0.075);
            }
            .table-success-custom {
                background-color: #2ecc71 !important;
                color: #2c3e50 !important;
            }
        </style>
    </head>

    <body>

        <!-- Inclui o menu lateral estruturado -->
        <?php include('sidebar.php'); ?>


        <div class="container-fluid">
            <div style="width: 100%; max-width: 83.33333%; padding: 1.5rem;">
                
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
                                <button type="button" class="btn btn-primary btn-sm">+ Peça</button>
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
                        
                        <div class="mt-4">
                            <button type="submit" class="btn btn-success">Salvar</button>
                            <button type="button" class="btn btn-warning">Editar</button>
                            <button type="button" class="btn btn-danger">Excluir</button>
                        </div>
                        
                        <label class="total-label">Total: R$ <?php echo number_format($total_orcamento, 2, ',', '.'); ?></label>
                    </fieldset>
                </form>

                <div class="mt-5">
                    <div class="mb-3" style="width: 33.33333%;">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Pesquisar...">
                            <button class="btn btn-primary">Buscar</button>
                        </div>
                    </div>
                    
                    <table class="table table-bordered table-hover">
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
                            <td>APROVADO</td>
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
