<?php
// php/editarOrcamento.php
include("conexao.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_GET['id'])) {
    $idOrcamento = intval($_GET['id']);
    
    // Captura os dados básicos do formulário
    $diagnostico = isset($_POST['nDiagnostico']) ? mysqli_real_escape_string($conn, $_POST['nDiagnostico']) : '';
    $maoObra = isset($_POST['nMaoObra']) ? floatval($_POST['nMaoObra']) : 0.0;
    $valorUni =isset($_POST['nValorUni']) ? floatval($_POST['nValorUni']) : 0.0;
    $valorTotal = isset($_POST['nTotal']) ? floatval($_POST['nTotal']) : 0.0;

    // 1. Atualiza os dados principais na tabela 'orcamento'
    $sql = "UPDATE orcamento SET 
                diagnostico = '$diagnostico', 
                maoObra = '$maoObra', 
                valorTotal = '$valorTotal',
                ValorUni = '$valorUni'
            WHERE idOrcamento = $idOrcamento";

    $resultado = mysqli_query($conn, $sql);


    // 2. Processa o Array de Peças do Estoque (nIdEstoque[])
    if ($resultado) {
        
        mysqli_query($conn, "DELETE FROM orcamento_peca WHERE Orcamento_idOrcamento = $idOrcamento");

        // Verifica se veio alguma peça selecionada no array
        if (isset($_POST['nIdEstoque']) && is_array($_POST['nIdEstoque'])) {
            
            foreach ($_POST['nIdEstoque'] as $idEstoque) {
                $idEstoqueLimpo = intval($idEstoque);
                // Se o ID for válido (maior que zero), insere o novo vínculo na tabela intermediária
                if ($idEstoqueLimpo > 0) {
                    $buscaEstoque = mysqli_query($conn, "SELECT peca FROM estoque WHERE idEstoque = $idEstoqueLimpo
                                                        OR idEstoque = $idEstoqueLimpo LIMIT 1");
                    $nomePecaPorExtenso = "";

                    if ($buscaEstoque && $reg = mysqli_fetch_assoc($buscaEstoque)) {
                        $nomePecaPorExtenso = mysqli_real_escape_string($conn, $reg['peca']);
                    }
                    // (Ajuste os nomes das colunas 'Estoque_idEstoque' e 'quantidade' conforme seu banco)
                    $sqlPeca = "INSERT INTO orcamento_peca (Orcamento_idOrcamento, Estoque_idEstoque, peca, quantidade) 
                                VALUES ($idOrcamento, $idEstoqueLimpo, '$nomePecaPorExtenso', 1)";
                    mysqli_query($conn, $sqlPeca);
                }
            }
        }
    }

    mysqli_close($conn);

    if ($resultado) {
        header("Location: ../orcamentos.php?mensagem=editado_com_sucesso");
    } else {
        echo "Erro ao atualizar banco de dados: " . mysqli_error($conn);
        exit;
    }
    exit;
}