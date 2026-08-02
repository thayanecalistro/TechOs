<?php
require_once(__DIR__ . '/../includes/conexao.php');

function getDadosRelatorio($status = '', $inicio = '', $fim = '', $busca = '') {
    global $conn;
    
    $where = " WHERE 1=1 ";
    if (!empty($status)) $where .= " AND os.status LIKE '%" . mysqli_real_escape_string($conn, $status) . "%' ";
    if (!empty($inicio)) $where .= " AND os.aberturaOS >= '" . mysqli_real_escape_string($conn, $inicio) . "' ";
    if (!empty($fim)) $where .= " AND os.aberturaOS <= '" . mysqli_real_escape_string($conn, $fim) . "' ";
    if (!empty($busca)) $where .= " AND (c.nomeCliente LIKE '%" . mysqli_real_escape_string($conn, $busca) . "%' OR os.idOS LIKE '%" . mysqli_real_escape_string($conn, $busca) . "%') ";

    // 1. Métricas da OS
    $query_metricas = "SELECT 
        COUNT(*) as total, 
        SUM(valorOS) as faturamento,
        SUM(CASE WHEN os.status = 'Pendente' THEN 1 ELSE 0 END) as pendentes,
        SUM(CASE WHEN os.status = 'Concluída' THEN 1 ELSE 0 END) as concluidas
        FROM os LEFT JOIN clientes c ON os.Cliente_idCliente = c.idCliente $where";
    
    $res = mysqli_query($conn, $query_metricas);
    $metricas = mysqli_fetch_assoc($res) ?? ['total'=>0, 'faturamento'=>0, 'pendentes'=>0, 'concluidas'=>0];

    // 2. Total de Clientes Cadastrados
    $res_cli = mysqli_query($conn, "SELECT COUNT(*) as total_clientes FROM clientes");
    $cli = mysqli_fetch_assoc($res_cli);

    // 3. Tabela
    $sql = "SELECT os.idOS, os.aberturaOS, os.status, os.valorOS, c.nomeCliente 
            FROM os 
            INNER JOIN clientes c ON os.Cliente_idCliente = c.idCliente 
            $where ORDER BY os.aberturaOS DESC";
            
    $query = mysqli_query($conn, $sql);
    $lista = [];
    while ($row = mysqli_fetch_assoc($query)) { $lista[] = $row; }

    return [
        'lista' => $lista, 
        'metricas' => $metricas, 
        'total_clientes' => $cli['total_clientes'] ?? 0
    ];
}
?>
