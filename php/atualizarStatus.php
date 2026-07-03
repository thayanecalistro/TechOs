<?php
include("conexao.php");

$idOrcamento = intval($_GET['id']);
$status = $_GET['status']; 

if($idOrcamento > 0 && ($status == 'aprovado' || $status == 'reprovado')) {
    
    // 1. Altera o status do orçamento
    mysqli_query($conn, "UPDATE orcamento SET status = '$status' WHERE idOrcamento = $idOrcamento");

    // 2. Se for aprovado, dispara automaticamente a inserção da nova OS
    if($status == 'aprovado') {
        $res = mysqli_query($conn, "SELECT Cliente_idCliente, Aparelho_idAparelho, valorTotal, diagnostico FROM orcamento WHERE idOrcamento = $idOrcamento");
        
        if($dados = mysqli_fetch_assoc($res)) {
            $clienteId = $dados['Cliente_idCliente'];
            $aparelhoId = $dados['Aparelho_idAparelho'];
            $valorOS = $dados['valorTotal'];
            $descricao = "OS automática gerada a partir do Orçamento número #$idOrcamento. Diagnóstico: " . mysqli_real_escape_string($conn, $dados['diagnostico']);
            
            // Gravação exata baseada na imagem 2 da tabela OS
            $sqlOS = "INSERT INTO os (aberturaOS, descricaoOS, valorOS, status, Aparelho_idAparelho, Cliente_idCliente) 
                      VALUES (NOW(), '$descricao', '$valorOS', 'em andamento', $aparelhoId, $clienteId)";
            
            if(mysqli_query($conn, $sqlOS)) {
                $idOSGerada = mysqli_insert_id($conn);
                
                // Vincula o ID da nova Ordem de serviço de volta no Orçamento correspondente
                mysqli_query($conn, "UPDATE orcamento SET OS_idOS = $idOSGerada WHERE idOrcamento = $idOrcamento");

                // =========================================================
                // LOGICA DE BAIXA AUTOMÁTICA NO ESTOQUE
                // =========================================================
                // Busca todas as peças associadas a este orçamento que possuem vínculo com o estoque
                $sqlPecasOrcamento = "SELECT Estoque_idEstoque, quantidade FROM orcamento_peca WHERE Orcamento_idOrcamento = $idOrcamento AND Estoque_idEstoque IS NOT NULL";
                $resPecas = mysqli_query($conn, $sqlPecasOrcamento);

                while ($item = mysqli_fetch_assoc($resPecas)) {
                    $idEstoque = intval($item['Estoque_idEstoque']);
                    $qtdUsada = intval($item['quantidade']);

                    // Executa o UPDATE decrementando a quantidade usada e recalculando o campo 'total' da tabela estoque
                    $sqlBaixa = "UPDATE estoque 
                                 SET quantidade = quantidade - $qtdUsada,
                                     total = valor * (quantidade - $qtdUsada) 
                                 WHERE idEstoque = $idEstoque";
                    
                    mysqli_query($conn, $sqlBaixa);
                }
            }
        }
    }
}

mysqli_close($conn);
header("Location: ../orcamentos.php");
exit();
?>