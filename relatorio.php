<?php
include("php/funcoes.php");
$currentPage = 'relatorio';

// Simulação de dados para os contadores do relatório
$total_movimentacoes = 184;
$orcamentos_gerados = 89;
$novos_clientes = 72;
$funcionarios_ativos = 23;
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechOS - Relatórios Gerais</title>
    <link rel="stylesheet" href="css/style_geral.css">
    <link rel="stylesheet" href="css/relatorios.css">
    <script src="js/relatorio.js" defer></script>
</head>
<body>
   
    <?php include('sidebar.php'); ?>

    <div class="page-content">
        
        <div class="os-header">
            <h2>Relatório Geral do Sistema</h2>
            <button id="btnExportar" class="btn-sucesso">Exportar PDF</button>
        </div>


        <div class="cards-grid">

            <div class="card card-blue">
                <div class="card-icon">
                    <i class="fas fa-file-invoice"></i>
                </div>
                <div class="card-info">
                    <h3><?php echo $total_movimentacoes; ?></h3>
                    <p>Total de Ações</p>
                </div>
            </div>
            <div class="card card-yellow">
                <div class="card-icon">
                    <i class="fas fa-calculator"></i>
                </div>
                <div class="card-info">
                    <h3><?php echo $orcamentos_gerados; ?></h3>
                    <p>Orçamentos</p>
                </div>
            </div>
        
            <div class="card card-teal">
                <div class="card-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="card-info">
                    <h3><?php echo $novos_clientes; ?></h3>
                    <p>Clientes Cadastrados</p>
                </div>
            </div>
            <div class="card card-green">
                <div class="card-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="card-info">
                    <h3><?php echo $funcionarios_ativos; ?></h3>
                    <p>Corpo Técnico</p>
                </div>
            </div>
            
        </div>

        <div class="table-section">        
            
            <fieldset class="search-fieldset">
                <legend>Filtros do Relatório</legend>
                <div class="search-box">
                    <div class="filter-group">
                        <label class="filter-label">Módulo:</label>
                        <select id="filtroModulo" class="btn-select">
                            <option value="todos">Todos os Módulos</option>
                            <option value="orcamento">Orçamentos</option>
                            <option value="cliente">Clientes</option>
                            <option value="funcionario">Funcionários</option>
                        </select>
                    </div>

                    <div class="filter-group">
                        <label class="filter-label">Período De:</label>
                        <input type="date" id="dataInicio" class="input-data">
                    </div>

                    <div class="filter-group">
                        <label class="filter-label">Até:</label>
                        <input type="date" id="dataFim" class="input-data">
                    </div>

                    <div class="filter-group btn-align">
                        <button type="button" class="btn btn-blue" id="btnFiltrar">Gerar Filtro</button>
                    </div>
                </div>
            </fieldset>
            
            <div class="table-card-fundo">
                <div class="table-container"> 
                    <table class="dashboard-table">
                        <thead>
                            <tr>
                                <th scope="col" style="width: 12%;">Data/Hora</th>
                                <th scope="col" style="width: 15%;">Módulo</th>
                                <th scope="col" style="width: 18%;">Usuário/Responsável</th>
                                <th scope="col" style="width: 40%;">Descrição da Atividade</th>
                                <th scope="col" style="width: 15%; text-align: center;">ID Relacionado</th>
                            </tr>
                        </thead>
                        <tbody id="corpo-relatorio">
                            <tr>
                                <td>16/06/2026 14:32</td>
                                <td><span class="badge-modulo mod-orcamento">Orçamento</span></td>
                                <td>Thay (Admin)</td>
                                <td>Criou novo orçamento para o cliente <strong>Luana</strong> (Apple iPhone 15)</td>
                                <td style="text-align: center;">#8</td>
                            </tr>
                            <tr>
                                <td>16/06/2026 11:15</td>
                                <td><span class="badge-modulo mod-cliente">Cliente</span></td>
                                <td>Thay (Admin)</td>
                                <td>Cadastrou o cliente <strong>Jacob</strong> no sistema</td>
                                <td style="text-align: center;">#2</td>
                            </tr>
                            <tr>
                                <td>15/06/2026 18:00</td>
                                <td><span class="badge-modulo mod-orcamento">Orçamento</span></td>
                                <td>Sistema</td>
                                <td>Status alterado para <span class="badge badge-aprovado">Aprovado</span> (ID: 3 - Otto)</td>
                                <td style="text-align: center;">#3</td>
                            </tr>
                            <tr>
                                <td>14/06/2026 09:22</td>
                                <td><span class="badge-modulo mod-funcionario">Funcionário</span></td>
                                <td>Thay (Admin)</td>
                                <td>Cadastrou um novo funcionário no banco de dados</td>
                                <td style="text-align: center;">#5</td>
                            </tr>
                            <?php 
                                //echo geraLinhasRelatorio(); 
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

</body>
</html>