<?php
$currentPage = 'dashboard';

// Simulação de dados do banco de dados (futuramente você substituirá por consultas SQL)
$total_OS_abertas = 12;
$total_orcamentos_pendentes = 5;
$total_clientes = 148;
$faturamento_mes = 4520.50;

$atividades_recentes = [
    ['id' => 102, 'cliente' => 'Carlos Silva', 'tipo' => 'Ordem de Serviço', 'status' => 'Aberta', 'data' => '16/06/2026'],
    ['id' => 45, 'cliente' => 'Ana Souza', 'tipo' => 'Orçamento', 'status' => 'Aprovado', 'data' => '16/06/2026'],
    ['id' => 101, 'cliente' => 'Marcos Lima', 'tipo' => 'Ordem de Serviço', 'status' => 'Concluída', 'data' => '15/06/2026'],
    ['id' => 44, 'cliente' => 'Julia Rossi', 'tipo' => 'Orçamento', 'status' => 'Recusado', 'data' => '14/06/2026'],
];
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
                            <?php foreach ($atividades_recentes as $atividade): ?>
                                <tr>
                                    <td>#<?php echo $atividade['id']; ?></td>
                                    <td><?php echo $atividade['cliente']; ?></td>
                                    <td><?php echo $atividade['tipo']; ?></td>
                                    <td><?php echo $atividade['data']; ?></td>
                                    <td>
                                        <?php 
                                            $statusClass = '';
                                            $status = strtolower($atividade['status']);
                                            if ($status == 'aberta') $statusClass = 'badge-aberto';
                                            elseif ($status == 'aprovado' || $status == 'concluída') $statusClass = 'badge-aprovado';
                                            elseif ($status == 'recusado') $statusClass = 'badge-recusado';
                                        ?>
                                        <span class="badge <?php echo $statusClass; ?>">
                                            <?php echo $atividade['status']; ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div> 
</body>
</html>