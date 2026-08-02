<?php
$currentPage = 'dashboard';

include("php/funcaoDashboard.php");


$total_OS_abertas = d_totalOsAbertas();
$total_orcamentos_pendentes = d_totalOrcamentosPendentes();
$total_clientes = d_totalClientes();
$faturamento_mes = d_faturamentoMes();

$atividades_recentes = d_listarUltimasAtividades();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechOS - Dashboard</title>
    <link rel="stylesheet" href="css/dashboard.css">
</head>
<body>

    <?php include('sidebar.php'); ?>

    <div class="page-content">
        
        <div class="dashboard-header">
            <h2>Olá, Administrador!</h2>
            <p>Aqui está o resumo do seu sistema hoje.</p>
        </div>

        <div class="cards-grid">
            
            <div class="card card-blue">
                <div class="card-icon">
                    <i class="fas fa-file-invoice"></i>
                </div>
                <div class="card-info">
                    <h3><?php echo $total_OS_abertas; ?></h3>
                    <p>OS Abertas</p>
                </div>
            </div>

            <div class="card card-yellow">
                <div class="card-icon">
                    <i class="fas fa-calculator"></i>
                </div>
                <div class="card-info">
                    <h3><?php echo $total_orcamentos_pendentes; ?></h3>
                    <p>Orçamentos Pendentes</p>
                </div>
            </div>

            <div class="card card-teal">
                <div class="card-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="card-info">
                    <h3><?php echo $total_clientes; ?></h3>
                    <p>Clientes Cadastrados</p>
                </div>
            </div>

            <div class="card card-green">
                <div class="card-icon">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <div class="card-info">
                    <h3>R$ <?php echo number_format($faturamento_mes, 2, ',', '.'); ?></h3>
                    <p>Faturamento do Mês</p>
                </div>
            </div>

        </div>

        <div class="dashboard-section">
            <div class="section-card">
                <h3>Últimas Atividades do Sistema</h3>
                
                <div class="table-container">
                    <table class="dashboard-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Cliente</th>
                                <th>Tipo</th>
                                <th>Data</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(count($atividades_recentes) > 0): ?>
                                <?php foreach ($atividades_recentes as $atividade): ?>
                                    <tr>
                                        <td>#<?php echo $atividade['id']; ?></td>
                                        <td><?php echo htmlspecialchars($atividade['cliente'], ENT_QUOTES); ?></td>
                                        <td><?php echo $atividade['tipo']; ?></td>
                                        <td><?php echo $atividade['data']; ?></td>
                                        <td>
                                            <?php 
                                                $statusClass = 'badge-aberto';
                                                $status = strtolower($atividade['status']);
                                                if ($status == 'aberta' || $status == 'aberto') $statusClass = 'badge-aberto';
                                                elseif ($status == 'aprovado' || $status == 'concluída' || $status == 'concluido' || $status == 'finalizado') $statusClass = 'badge-aprovado';
                                                elseif ($status == 'recusado' || $status == 'reprovado') $statusClass = 'badge-recusado';
                                            ?>
                                            <span class="badge <?php echo $statusClass; ?>">
                                                <?php echo ucfirst($atividade['status']); ?>
                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" style="text-align:center; color:#829ab1;">Nenhuma atividade recente registrada no banco de dados.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div> 
</body>
</html>