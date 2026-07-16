<?php

// 1. CONTA AS OSs ABERTAS / EM ANDAMENTO
function d_totalOsAbertas() {
    include("includes/conexao.php");
    $sql = "SELECT COUNT(*) AS total FROM os WHERE LOWER(status) IN ('aberta', 'aberto', 'em andamento')";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    mysqli_close($conn);
    return $row['total'] ? $row['total'] : 0;
}

// 2. CONTA OS ORÇAMENTOS PENDENTES (STATUS ABERTO)
function d_totalOrcamentosPendentes() {
    include("includes/conexao.php");
    $sql = "SELECT COUNT(*) AS total FROM orcamento WHERE LOWER(status) = 'aberto'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    mysqli_close($conn);
    return $row['total'] ? $row['total'] : 0;
}

// 3. CONTA TOTAL DE CLIENTES CADASTRADOS
function d_totalClientes() {
    include("includes/conexao.php");
    $sql = "SELECT COUNT(*) AS total FROM clientes";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    mysqli_close($conn);
    return $row['total'] ? $row['total'] : 0;
}

// 4. SOMA O FATURAMENTO DO MÊS ATUAL (BASEADO NAS OSs CONCLUÍDAS)
function d_faturamentoMes() {
    include("includes/conexao.php");
    // Soma valorOS de registros finalizados/concluídos
    $sql = "SELECT SUM(valorOS) AS total FROM os WHERE LOWER(status) IN ('finalizado', 'concluido')";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    mysqli_close($conn);
    return $row['total'] ? (float)$row['total'] : 0.0;
}

// 5. RETORNA UM ARRAY UNIFICADO COM AS ÚLTIMAS ATIVIDADES REAIS DO BANCO
function d_listarUltimasAtividades() {
    include("includes/conexao.php");
    $atividades = [];

    // Busca as últimas 3 OSs modificadas/criadas
    $sqlOS = "SELECT os.idOS AS id, c.nomeCliente AS cliente, 'Ordem de Serviço' AS tipo, 
                     os.status, os.aberturaOS AS dataOriginal
              FROM os os
              INNER JOIN clientes c ON os.Cliente_idCliente = c.idCliente
              ORDER BY os.idOS DESC LIMIT 3";
    
    $resOS = mysqli_query($conn, $sqlOS);
    if ($resOS) {
        while ($r = mysqli_fetch_assoc($resOS)) {
            $atividades[] = [
                'id' => $r['id'],
                'cliente' => $r['cliente'],
                'tipo' => $r['tipo'],
                'status' => $r['status'],
                'data' => date('d/m/Y', strtotime($r['dataOriginal'])),
                'timestamp' => strtotime($r['dataOriginal'])
            ];
        }
    }

    // Busca os últimos 3 orçamentos modificados/criados
    $sqlOrc = "SELECT o.idOrcamento AS id, c.nomeCliente AS cliente, 'Orçamento' AS tipo, 
                      o.status, o.dataOrcamento AS dataOriginal
               FROM orcamento o
               INNER JOIN clientes c ON o.Cliente_idCliente = c.idCliente
               ORDER BY o.idOrcamento DESC LIMIT 3";

    $resOrc = mysqli_query($conn, $sqlOrc);
    if ($resOrc) {
        while ($r = mysqli_fetch_assoc($resOrc)) {
            $atividades[] = [
                'id' => $r['id'],
                'cliente' => $r['cliente'],
                'tipo' => $r['tipo'],
                'status' => $r['status'],
                'data' => date('d/m/Y', strtotime($r['dataOriginal'])),
                'timestamp' => strtotime($r['dataOriginal'])
            ];
        }
    }

    // Organiza o array mesclado para que as datas mais recentes fiquem no topo
    usort($atividades, function($a, $b) {
        return $b['timestamp'] - $a['timestamp'];
    });

    // Retorna apenas as 5 atividades mais recentes no total
    return array_slice($atividades, 0, 5);
}
//Função para trazer dados para o relatório
function d_buscarOS($status = '', $data_inicio = '', $data_fim = '') {
    include("includes/conexao.php");
    $sql = "SELECT os.idOS, os.aberturaOS, os.status, c.nomeCliente 
            FROM os 
            INNER JOIN clientes c ON os.Cliente_idCliente = c.idCliente 
            WHERE 1=1";


    if (!empty($status)) {
        $sql .= " AND os.status LIKE '%" . mysqli_real_escape_string($conn, $status) . "%'";
    }
    if (!empty($data_inicio)) {
        $sql .= " AND os.aberturaOS >= '" . mysqli_real_escape_string($conn, $data_inicio) . "'";
    }
    if (!empty($data_fim)) {
        $sql .= " AND os.aberturaOS <= '" . mysqli_real_escape_string($conn, $data_fim) . "'";
    }
    
    $result = mysqli_query($conn, $sql);
    $dados = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $dados[] = $row;
    }
    mysqli_close($conn);
    return $dados;
}
?>