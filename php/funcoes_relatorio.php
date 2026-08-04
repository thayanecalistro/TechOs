<?php

function getDadosRelatorio($status = '', $data_inicio = '', $data_fim = '', $busca = '') {
    include("includes/conexao.php");

    // 1. FILTROS DINÂMICOS DA OS
    $whereOS = ["1=1"];
    if (!empty($status)) {
        $whereOS[] = "LOWER(os.status) LIKE LOWER('%" . mysqli_real_escape_string($conn, $status) . "%')";
    }
    if (!empty($data_inicio)) {
        $whereOS[] = "DATE(os.aberturaOS) >= '" . mysqli_real_escape_string($conn, $data_inicio) . "'";
    }
    if (!empty($data_fim)) {
        $whereOS[] = "DATE(os.aberturaOS) <= '" . mysqli_real_escape_string($conn, $data_fim) . "'";
    }
    if (!empty($busca)) {
        $whereOS[] = "c.nomeCliente LIKE '%" . mysqli_real_escape_string($conn, $busca) . "%'";
    }
    $stringWhereOS = implode(" AND ", $whereOS);

    // 2. BUSCA DA LISTA DE ATIVIDADES (OSs + Orçamentos)
    $atividades = [];

    // Busca OSs
    $sqlOS = "SELECT os.idOS AS id, c.nomeCliente AS cliente, 'Ordem de Serviço' AS tipo, 
                     os.status, os.aberturaOS AS dataOriginal
              FROM os os
              LEFT JOIN clientes c ON os.Cliente_idCliente = c.idCliente
              WHERE $stringWhereOS
              ORDER BY os.idOS DESC";
    
    $resOS = mysqli_query($conn, $sqlOS);
    if ($resOS) {
        while ($r = mysqli_fetch_assoc($resOS)) {
            $atividades[] = [
                'id' => $r['id'],
                'cliente' => $r['cliente'] ?? 'Cliente Não Identificado',
                'tipo' => $r['tipo'],
                'status' => $r['status'],
                'data' => date('d/m/Y', strtotime($r['dataOriginal'])),
                'timestamp' => strtotime($r['dataOriginal'])
            ];
        }
    }

    // Busca Orçamentos se não houver filtro exclusivo de status da OS
    if (empty($status) || stristr($status, 'orc') || stristr($status, 'orç')) {
        $whereOrc = ["1=1"];
        if (!empty($data_inicio)) $whereOrc[] = "DATE(o.dataOrcamento) >= '" . mysqli_real_escape_string($conn, $data_inicio) . "'";
        if (!empty($data_fim)) $whereOrc[] = "DATE(o.dataOrcamento) <= '" . mysqli_real_escape_string($conn, $data_fim) . "'";
        if (!empty($busca)) $whereOrc[] = "c.nomeCliente LIKE '%" . mysqli_real_escape_string($conn, $busca) . "%'";
        $stringWhereOrc = implode(" AND ", $whereOrc);

        $sqlOrc = "SELECT o.idOrcamento AS id, c.nomeCliente AS cliente, 'Orçamento' AS tipo, 
                          o.status, o.dataOrcamento AS dataOriginal
                   FROM orcamento o
                   LEFT JOIN clientes c ON o.Cliente_idCliente = c.idCliente
                   WHERE $stringWhereOrc
                   ORDER BY o.idOrcamento DESC";

        $resOrc = mysqli_query($conn, $sqlOrc);
        if ($resOrc) {
            while ($r = mysqli_fetch_assoc($resOrc)) {
                $atividades[] = [
                    'id' => $r['id'],
                    'cliente' => $r['cliente'] ?? 'Cliente Não Identificado',
                    'tipo' => $r['tipo'],
                    'status' => $r['status'],
                    'data' => date('d/m/Y', strtotime($r['dataOriginal'])),
                    'timestamp' => strtotime($r['dataOriginal'])
                ];
            }
        }
    }

    // Ordena as atividades por data
    usort($atividades, function($a, $b) {
        return $b['timestamp'] - $a['timestamp'];
    });

    // 3. CÁLCULO DAS MÉTRICAS DOS CARDS
    $resTotal = mysqli_query($conn, "SELECT COUNT(*) as total FROM os");
    $totalOS = mysqli_fetch_assoc($resTotal)['total'] ?? 0;

    $resFat = mysqli_query($conn, "SELECT SUM(valorOS) as total FROM os WHERE LOWER(status) IN ('finalizado', 'concluido', 'concluída')");
    $faturamento = mysqli_fetch_assoc($resFat)['total'] ?? 0.0;

    $resPend = mysqli_query($conn, "SELECT COUNT(*) as total FROM os WHERE LOWER(status) IN ('andamento')");
    $pendentes = mysqli_fetch_assoc($resPend)['total'] ?? 0;

    $resConc = mysqli_query($conn, "SELECT COUNT(*) as total FROM os WHERE LOWER(status) IN ('pronto', 'devolvido')");
    $concluidas = mysqli_fetch_assoc($resConc)['total'] ?? 0;

    $resCli = mysqli_query($conn, "SELECT COUNT(*) as total FROM clientes");
    $totalClientes = mysqli_fetch_assoc($resCli)['total'] ?? 0;

    mysqli_close($conn);

    return [
        'atividades' => $atividades,
        'metricas' => [
            'total' => $totalOS,
            'faturamento' => $faturamento,
            'pendentes' => $pendentes,
            'concluidas' => $concluidas
        ],
        'total_clientes' => $totalClientes
    ];
}
?>