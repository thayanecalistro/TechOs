<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

$currentPage = 'dashboard';
include_once("php/funcoes.php");
include("php/funcaoDashboard.php");

// Indicadores dos Cards
$os_abertas = d_totalOsAbertas();
$os_execucao = d_totalOsExecucao();
$os_prontas = d_totalOsProntas();
$tat = d_tempoMedioReparo();

// Dados JSON para os Gráficos
$dadosBarras = json_encode(d_dadosGraficoBarras());
$dadosDefeitos = json_encode(d_dadosGraficoDefeitos());
$dadosStatus = json_encode(d_dadosGraficoStatusOS());
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechOS - Dashboard</title>
    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Chart.js para os gráficos -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

    <?php include('sidebar.php'); ?>

    <div class="page-content">
        
        <div class="dashboard-header">
            <h2>Olá, Administrador!</h2>
            <p>Acompanhamento de métricas operacionais e gráficos do sistema.</p>
        </div>

        <!-- CARDS TOPO -->
        <div class="cards-grid">
            <div class="card card-yellow">
                <div class="card-icon"><i class="fas fa-clock"></i></div>
                <div class="card-info">
                    <h3><?php echo $os_abertas; ?></h3>
                    <p>OS Pendentes</p>
                </div>
            </div>

            <div class="card card-blue">
                <div class="card-icon"><i class="fas fa-tools"></i></div>
                <div class="card-info">
                    <h3><?php echo $os_execucao; ?></h3>
                    <p>OS Em Execução</p>
                </div>
            </div>

            <div class="card card-teal">
                <div class="card-icon"><i class="fas fa-check-circle"></i></div>
                <div class="card-info">
                    <h3><?php echo $os_prontas; ?></h3>
                    <p>Aguardando Retirada</p>
                </div>
            </div>

            <div class="card card-green">
                <div class="card-icon"><i class="fas fa-stopwatch"></i></div>
                <div class="card-info">
                    <h3><?php echo $tat; ?></h3>
                    <p>Tempo Médio Reparo</p>
                </div>
            </div>
        </div>

        <!-- ESTRUTURA DOS GRÁFICOS (Inspirada no Layout) -->
        <div class="charts-container" style="display: flex; gap: 20px; width: 100%; margin-top: 10px;">
            
            <!-- COLUNA ESQUERDA: Gráfico de Barras + Gráfico de Área -->
            <div style="flex: 3; display: flex; flex-direction: column; gap: 20px;">
                
                <!-- 1. Gráfico de Barras Duplas (Orçamentos vs OS) -->
                <div class="section-card">
                    <h3>Comparativo Mensal: Orçamentos vs OS Abertas</h3>
                    <div style="height: 220px; position: relative;">
                        <canvas id="barChart"></canvas>
                    </div>
                </div>

                <!-- 2. Gráfico de Área / Linha Suave (Volume de Defeitos) -->
                <div class="section-card">
                    <h3>Principais Defeitos / Diagnósticos</h3>
                    <div style="height: 200px; position: relative;">
                        <canvas id="lineChart"></canvas>
                    </div>
                </div>

            </div>

            <!-- COLUNA DIREITA: Gráfico de Rosca / Donut (Status da OS) -->
            <div style="flex: 1.2;">
                <div class="section-card" style="height: 100%; display: flex; flex-direction: column; justify-content: center; align-items: center;">
                    <h3>Status Geral das OS</h3>
                    <div style="width: 100%; height: 260px; position: relative; margin-top: 15px;">
                        <canvas id="doughnutChart"></canvas>
                    </div>
                </div>
            </div>

        </div>

    </div>

    <!-- RENDERIZAÇÃO DOS GRÁFICOS COM CHART.JS -->
    <script>
        const dadosBarras = <?php echo $dadosBarras; ?>;
        const dadosDefeitos = <?php echo $dadosDefeitos; ?>;
        const dadosStatus = <?php echo $dadosStatus; ?>;

        // Colors inspiradas no layout enviado (Azul Escuro, Amarelo/Laranja, Ciano)
        const colorPrimary = '#1a304a';
        const colorSecondary = '#f1c40f';
        const colorCyan = '#62b6cb';
        const colorGreen = '#2cb1bc';

        // 1. Gráfico de Barras
        new Chart(document.getElementById('barChart'), {
            type: 'bar',
            data: {
                labels: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
                datasets: [
                    {
                        label: 'Orçamentos',
                        data: dadosBarras.orcamentos,
                        backgroundColor: '#486581',
                        borderRadius: 4
                    },
                    {
                        label: 'OS Abertas',
                        data: dadosBarras.os,
                        backgroundColor: colorSecondary,
                        borderRadius: 4
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { labels: { color: '#9fb3c8' } } },
                scales: {
                    x: { ticks: { color: '#9fb3c8' }, grid: { display: false } },
                    y: { ticks: { color: '#9fb3c8' }, grid: { color: '#243b53' } }
                }
            }
        });

        // 2. Gráfico de Linha / Área (Defeitos)
        new Chart(document.getElementById('lineChart'), {
            type: 'line',
            data: {
                labels: dadosDefeitos.labels.length ? dadosDefeitos.labels : ['Sem Dados'],
                datasets: [{
                    label: 'Ocorrências',
                    data: dadosDefeitos.totais.length ? dadosDefeitos.totais : [0],
                    borderColor: colorSecondary,
                    backgroundColor: 'rgba(241, 196, 15, 0.25)',
                    fill: true,
                    tension: 0.4,
                    pointRadius: 4,
                    pointBackgroundColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    x: { ticks: { color: '#9fb3c8' }, grid: { display: false } },
                    y: { ticks: { color: '#9fb3c8' }, grid: { color: '#243b53' } }
                }
            }
        });

        // 3. Gráfico de Rosca / Donut (Status)
        new Chart(document.getElementById('doughnutChart'), {
            type: 'doughnut',
            data: {
                labels: dadosStatus.labels.length ? dadosStatus.labels : ['Nenhuma OS'],
                datasets: [{
                    data: dadosStatus.totais.length ? dadosStatus.totais : [1],
                    backgroundColor: [colorSecondary, colorCyan, colorGreen, '#d9534f', '#486581'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { color: '#9fb3c8', padding: 15 }
                    }
                },
                cutout: '70%'
            }
        });
    </script>
</body>
</html>