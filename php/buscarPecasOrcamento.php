<?php
// php/buscarPecasOrcamento.php
include("includes/conexao.php");

$pecas = [];

if (isset($_GET['id'])) {
    $idOrcamento = intval($_GET['id']);
    
    // Busca todas as peças vinculadas a este orçamento na tabela orcamento_peca
    $query = "SELECT Estoque_idEstoque, peca, quantidade, valorUnitario 
              FROM orcamento_peca 
              WHERE Orcamento_idOrcamento = $idOrcamento";
              
    $resultado = mysqli_query($conn, $query);
    
    if ($resultado) {
        while ($reg = mysqli_fetch_assoc($resultado)) {
            $pecas[] = $reg;
        }
    }
}

// Define o cabeçalho para o JavaScript entender que a resposta é uma lista (JSON)
header('Content-Type: application/json');
echo json_encode($pecas);
exit;
?>