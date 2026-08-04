<?php

// 1. CONTA AS OSs ABERTAS / PENDENTES
function d_totalOsAbertas() {
    include("includes/conexao.php");
    $sql = "SELECT COUNT(*) AS total FROM os WHERE LOWER(status) IN ('andamento', 'pronto', 'devolvido');";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    mysqli_close($conn);
    return $row['total'] ? $row['total'] : 0;
}

// 2. CONTA AS OSs EM EXECUÇÃO (NA BANCADA)
function d_totalOsExecucao() {
    include("includes/conexao.php");
    $sql = "SELECT COUNT(*) AS total FROM os WHERE LOWER(status) IN ('em andamento', 'andamento', 'em execucao')";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    mysqli_close($conn);
    return $row['total'] ? $row['total'] : 0;
}

// 3. CONTA AS OSs PRONTAS / AGUARDANDO RETIRADA
function d_totalOsProntas() {
    include("includes/conexao.php");
    $sql = "SELECT COUNT(*) AS total FROM os WHERE LOWER(status) IN ('pronto', 'prontas', 'aguardando retirada')";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    mysqli_close($conn);
    return $row['total'] ? $row['total'] : 0;
}

// 4. TEMPO MÉDIO DE REPARO (TAT em dias/horas)
function d_tempoMedioReparo() {
    include("includes/conexao.php");
    $sql = "SELECT AVG(TIMESTAMPDIFF(HOUR, aberturaOS, fechamentoOS)) AS media_horas 
            FROM os 
            WHERE fechamentoOS IS NOT NULL";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    mysqli_close($conn);
    
    if ($row['media_horas']) {
        $horas = round($row['media_horas']);
        return $horas > 24 ? round($horas / 24, 1) . " dias" : $horas . " hrs";
    }
    return "N/A";
}

// 5. SOMA O FATURAMENTO BRUTO
function d_faturamentoMes() {
    include("includes/conexao.php");
    $sql = "SELECT SUM(valorOS) AS total FROM os WHERE LOWER(status) IN ('finalizado', 'concluido', 'concluída')";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    mysqli_close($conn);
    return $row['total'] ? (float)$row['total'] : 0.0;
}

// 6. CALCULA O TICKET MÉDIO POR CLIENTE
function d_ticketMedio() {
    include("includes/conexao.php");
    $sql = "SELECT AVG(valorOS) AS media FROM os WHERE LOWER(status) IN ('finalizado', 'concluido', 'concluída')";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    mysqli_close($conn);
    return $row['media'] ? (float)$row['media'] : 0.0;
}

// 7. CONTA PEÇAS COM ESTOQUE CRÍTICO (Menos de 4 unidades)
function d_estoqueCritico() {
    include("includes/conexao.php");
    $sql = "SELECT COUNT(*) AS total FROM estoque WHERE quantidade <= 4";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    mysqli_close($conn);
    return $row['total'] ? $row['total'] : 0;
}

// 8. BUSCA O ITEM COM MAIOR GIRO NO ESTOQUE
function d_peçaMaisVendida() {
    include("includes/conexao.php");
    $sql = "SELECT peca, SUM(quantidade) as total_saida 
            FROM orcamento_peca 
            GROUP BY peca 
            ORDER BY total_saida DESC LIMIT 1";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    mysqli_close($conn);
    return $row ? $row['peca'] : "Sem movimentação";
}

// 9. DADOS DO GRÁFICO DE BARRAS: Comparativo de Orçamentos vs OS Criadas por Mês
function d_dadosGraficoBarras() {
    include("includes/conexao.php");
    
    // Inicializa arrays com os meses do ano (Jan a Dez)
    $orcamentos = array_fill(1, 12, 0);
    $os = array_fill(1, 12, 0);
    $anoAtual = date('Y');

    // Busca Orçamentos por Mês[cite: 1, 3]
    $sqlOrc = "SELECT MONTH(dataOrcamento) as mes, COUNT(*) as total FROM orcamento WHERE YEAR(dataOrcamento) = '$anoAtual' GROUP BY MONTH(dataOrcamento)";
    $resOrc = mysqli_query($conn, $sqlOrc);
    while($r = mysqli_fetch_assoc($resOrc)) {
        $orcamentos[(int)$r['mes']] = (int)$r['total'];
    }

    // Busca OSs por Mês[cite: 1, 3]
    $sqlOS = "SELECT MONTH(aberturaOS) as mes, COUNT(*) as total FROM os WHERE YEAR(aberturaOS) = '$anoAtual' GROUP BY MONTH(aberturaOS)";
    $resOS = mysqli_query($conn, $sqlOS);
    while($r = mysqli_fetch_assoc($resOS)) {
        $os[(int)$r['mes']] = (int)$r['total'];
    }

    mysqli_close($conn);

    return [
        'orcamentos' => array_values($orcamentos),
        'os' => array_values($os)
    ];
}

// 10. DADOS DO GRÁFICO DE ÁREA: Ranking de Defeitos Mais Comuns (Diagnósticos)
function d_dadosGraficoDefeitos() {
    include("includes/conexao.php");
    $labels = [];
    $totais = [];

    // Agrupa pelos diagnósticos mais cadastrados nos orçamentos[cite: 1, 3]
    $sql = "SELECT COALESCE(NULLIF(diagnostico, ''), 'Outros/Manutenção') AS defeito, COUNT(*) AS total 
            FROM orcamento 
            GROUP BY defeito 
            ORDER BY total DESC LIMIT 5";
    
    $res = mysqli_query($conn, $sql);
    while($r = mysqli_fetch_assoc($res)) {
        $labels[] = $r['defeito'];
        $totais[] = (int)$r['total'];
    }

    mysqli_close($conn);

    return [
        'labels' => $labels,
        'totais' => $totais
    ];
}

// 11. DADOS DO GRÁFICO DE ROSCA (DONUT): Distribuição dos Status das OS
function d_dadosGraficoStatusOS() {
    include("includes/conexao.php");
    $labels = [];
    $totais = [];

    $sql = "SELECT status, COUNT(*) AS total FROM os GROUP BY status";
    $res = mysqli_query($conn, $sql);
    while($r = mysqli_fetch_assoc($res)) {
        $labels[] = ucfirst($r['status']);
        $totais[] = (int)$r['total'];
    }

    mysqli_close($conn);

    return [
        'labels' => $labels,
        'totais' => $totais
    ];
}
?>