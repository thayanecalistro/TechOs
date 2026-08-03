<?php
session_start();

require_once('php/funcoes_relatorio.php');
$currentPage = 'relatorios';

$dados = getDadosRelatorio(
    $_GET['status'] ?? '', 
    $_GET['data_inicio'] ?? '', 
    $_GET['data_fim'] ?? '', 
    $_GET['busca'] ?? ''
);

// Pega a lista tratada vinda da função
$atividades_recentes = $dados['atividades'];
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Relatório Gerencial - TechOS</title>
    <link rel="stylesheet" href="css/sidebar.css">
    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="stylesheet" href="css/relatorio.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <?php include('sidebar.php'); ?>

    <div class="page-content">
        <!-- HEADER -->
        <div class="relatorio-header">
            <div>
                <h2>Relatório Gerencial</h2>
                <p style="color:#9fb3c8; margin-top:5px;">Análise detalhada de ordens de serviço</p>
            </div>
            <button id="btnExportar" class="btn-sucesso" style="background-color: #28a745; border:none; padding:12px 20px; border-radius:4px; color:white; cursor:pointer;">
                <i class="fas fa-file-pdf"></i> Exportar PDF
            </button>
        </div>

        <!-- CARDS -->
        <div class="cards-grid">
            <div class="card card-blue"><div class="card-icon"><i class="fas fa-file-invoice"></i></div><div class="card-info"><h3><?= $dados['metricas']['total'] ?></h3><p>Total OS</p></div></div>
            <div class="card card-teal"><div class="card-icon"><i class="fas fa-dollar-sign"></i></div><div class="card-info"><h3>R$ <?= number_format($dados['metricas']['faturamento']??0, 2, ',', '.') ?></h3><p>Faturamento</p></div></div>
            <div class="card card-yellow"><div class="card-icon"><i class="fas fa-clock"></i></div><div class="card-info"><h3><?= $dados['metricas']['pendentes'] ?></h3><p>Pendentes</p></div></div>
            <div class="card card-green"><div class="card-icon"><i class="fas fa-check-circle"></i></div><div class="card-info"><h3><?= $dados['metricas']['concluidas'] ?></h3><p>Concluídas</p></div></div>
            <div class="card card-blue" style="border-color: #a855f7;"><div class="card-icon" style="color: #a855f7;"><i class="fas fa-users"></i></div><div class="card-info"><h3><?=$dados['total_clientes']?></h3><p>Clientes Cadastrados</p></div></div>
        </div>

        <!-- FILTROS -->
        <fieldset class="search-fieldset" style="margin-top: 30px; background-color: #1a304a; border: 1px solid #62b6cb;">
            <legend style="color: #62b6cb; font-weight: bold; padding: 0 10px;">Filtros e Pesquisa Rápida</legend>
            <form method="GET" class="search-box-relatorio" style="display: flex; gap: 15px; align-items: flex-end;">
                <div class="filter-group"><label class="filter-label">Pesquisar Cliente</label><input type="text" name="busca" class="btn-select" value="<?= htmlspecialchars($_GET['busca']??'', ENT_QUOTES) ?>"></div>
                <div class="filter-group"><label class="filter-label">Status</label><input type="text" name="status" class="btn-select" value="<?= htmlspecialchars($_GET['status']??'', ENT_QUOTES) ?>"></div>
                <div class="filter-group"><label class="filter-label">De:</label><input type="date" name="data_inicio" class="input-data" value="<?= $_GET['data_inicio']??'' ?>"></div>
                <div class="filter-group"><label class="filter-label">Até:</label><input type="date" name="data_fim" class="input-data" value="<?= $_GET['data_fim']??'' ?>"></div>
                <button type="submit" class="btn btn-blue" style="background-color: #62b6cb; color: #102a43; font-weight:bold; height:34px; padding:0 20px;">Filtrar</button>
            </form>
        </fieldset>

        <!-- SEÇÃO DA TABELA -->
        <div class="dashboard-section">
            <div class="section-card">
                <h3>Relatório de Atividades Registradas</h3>
                
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
                                                if ($status == 'aberta' || $status == 'aberto' || $status == 'em andamento') $statusClass = 'badge-aberto';
                                                elseif ($status == 'aprovado' || $status == 'concluída' || $status == 'concluido' || $status == 'finalizado' || $status == 'pronto') $statusClass = 'badge-aprovado';
                                                elseif ($status == 'recusado' || $status == 'reprovado' || $status == 'cancelado') $statusClass = 'badge-recusado';
                                            ?>
                                            <span class="badge <?php echo $statusClass; ?>">
                                                <?php echo ucfirst($atividade['status']); ?>
                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" style="text-align:center; color:#829ab1;">Nenhum registro encontrado com os filtros aplicados.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script>
        document.getElementById('btnExportar').addEventListener('click', () => {
            const opt = { margin: 1, filename: 'relatorio.pdf', html2canvas: { scale: 2 }, jsPDF: { orientation: 'landscape' } };
            html2pdf().set(opt).from(document.querySelector('.page-content')).save();
        });
    </script>
</body>
</html>