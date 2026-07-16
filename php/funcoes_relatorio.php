<?php
// Carrega a conexão com o banco
require_once(__DIR__ . '/../includes/conexao.php');

function buscarRelatorioOS($status = '', $data_inicio = '', $data_fim = '') {
    global $conn; // Usa a conexão do seu arquivo conexao.php
    
    $sql = "SELECT os.idOS, os.aberturaOS, os.status, os.valorOS, c.nomeCliente 
            FROM os 
            INNER JOIN clientes c ON os.Cliente_idCliente = c.idCliente 
            WHERE 1=1";

    if (!empty($status)) {
        $sql .= " AND os.status = '" . mysqli_real_escape_string($conn, $status) . "'";
    }
    if (!empty($data_inicio)) {
        $sql .= " AND os.aberturaOS >= '" . mysqli_real_escape_string($conn, $data_inicio) . "'";
    }
    if (!empty($data_fim)) {
        $sql .= " AND os.aberturaOS <= '" . mysqli_real_escape_string($conn, $data_fim) . "'";
    }

    $sql .= " ORDER BY os.aberturaOS DESC";
    
    $query = mysqli_query($conn, $sql);
    $lista = [];
    while ($row = mysqli_fetch_assoc($query)) {
        $lista[] = $row;
    }
    return $lista;
}
?>
