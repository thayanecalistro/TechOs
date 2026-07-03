<?php
// funcaoestoque.php

function funcaoestoque($conn, $acao, $dados) {
    $idEstoque      = isset($dados['idEstoque']) ? intval($dados['idEstoque']) : 0;
    $nomeFornecedor = isset($dados['NomeFornecedor']) ? trim($dados['NomeFornecedor']) : '';
    $peca           = isset($dados['peca']) ? trim($dados['peca']) : '';
    $valor          = isset($dados['valor']) ? floatval($dados['valor']) : 0.0;
    $quantidade     = isset($dados['quantidade']) ? intval($dados['quantidade']) : 0;
    $total          = $valor * $quantidade; // Cálculo seguro no servidor

    switch ($acao) {
        case 'inserir':
            $sql = "INSERT INTO estoque (NomeFornecedor, peca, valor, quantidade, total) VALUES (?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "ssdid", $nomeFornecedor, $peca, $valor, $quantidade, $total);
            break;

        case 'editar':
            $sql = "UPDATE estoque SET NomeFornecedor = ?, peca = ?, valor = ?, quantidade = ?, total = ? WHERE idEstoque = ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "ssdidi", $nomeFornecedor, $peca, $valor, $quantidade, $total, $idEstoque);
            break;

        case 'excluir':
            $sql = "DELETE FROM estoque WHERE idEstoque = ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "i", $idEstoque);
            break;
            
        default:
            return ['status' => 'erro', 'mensagem' => 'Ação inválida.'];
    }

    if (isset($stmt) && mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        return ['status' => 'sucesso', 'mensagem' => 'Operação realizada com sucesso!'];
    }
    
    return ['status' => 'erro', 'mensagem' => 'Erro ao executar no banco de dados.'];
}
?>