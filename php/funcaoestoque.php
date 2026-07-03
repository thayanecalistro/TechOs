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

function listarProdutosEstoque($conn, $pesquisa = '') {
    $html = "";
    $produtos = [];

    // 1. Processa a Query com ou sem filtro de pesquisa
    if (!empty($pesquisa)) {
        $sql_busca = "SELECT * FROM estoque WHERE NomeFornecedor LIKE ? OR peca LIKE ? ORDER BY idEstoque DESC";
        $stmt = mysqli_prepare($conn, $sql_busca);
        $param = "%" . $pesquisa . "%";
        mysqli_stmt_bind_param($stmt, "ss", $param, $param);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);
    } else {
        $sql_busca = "SELECT * FROM estoque ORDER BY idEstoque DESC";
        $resultado = mysqli_query($conn, $sql_busca);
    }

    // 2. Monta o array de produtos
    if ($resultado && mysqli_num_rows($resultado) > 0) {
        while ($linha = mysqli_fetch_assoc($resultado)) {
            $produtos[] = $linha;
        }
    }

    // 3. Renderiza o HTML das linhas da tabela dinamicamente
    if (!empty($produtos)) {
        foreach ($produtos as $prod) {
            $id = $prod['idEstoque'];
            $fornecedor = htmlspecialchars($prod['NomeFornecedor'], ENT_QUOTES, 'UTF-8');
            $peca = htmlspecialchars($prod['peca'], ENT_QUOTES, 'UTF-8');
            $valor = number_format($prod['valor'], 2, ',', '.');
            $quantidade = $prod['quantidade'];
            $total = number_format($prod['total'], 2, ',', '.');

            $html .= "<tr>
                        <td>{$id}</td>
                        <td>{$fornecedor}</td>
                        <td>{$peca}</td>
                        <td>R$ {$valor}</td>
                        <td>{$quantidade}</td>
                        <td>R$ {$total}</td>
                        <td>
                            <button type='button' class='acao-editar btn btn-sm btn-warning' 
                                data-id='{$id}'
                                data-fornecedor='{$fornecedor}'
                                data-peca='{$peca}'
                                data-valor='{$prod['valor']}'
                                data-quantidade='{$quantidade}'
                                data-total='{$prod['total']}'>Editar</button>
                            
                            <a href='php/salvarEstoque.php?excluir_id={$id}' class='btn btn-sm btn-danger' onclick=\"return confirm('Deseja realmente excluir?')\">Excluir</a>
                        </td>
                      </tr>";
        }
    } else {
        $html .= "<tr><td colspan='7' class='sem-dados text-center'>Nenhum item em estoque.</td></tr>";
    }

    return $html;
}
?>