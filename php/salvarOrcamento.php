<?php
include("conexao.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cliente = intval($_POST['Cliente_idCliente']);
    $aparelho = intval($_POST['Aparelho_idAparelho']);
    $diagnostico = mysqli_real_escape_string($conn, $_POST['nDiagnostico']);
    $maoObra = floatval($_POST['nMaoObra']);
    $status = mysqli_real_escape_string($conn, $_POST['nStatus']); 

    $arrPecas = $_POST['nPeca'] ?? [];
    $arrValores = $_POST['nValorUni'] ?? [];
    $arrQtds = $_POST['nQtd'] ?? [];
    $arrIdsEstoque = $_POST['nIdEstoque'] ?? [];

    // 1. Calcula os valores totais das peças do estoque
    $somaValoresPecas = 0;
    $nomesPecasArray = [];

    for ($i = 0; $i < count($arrIdsEstoque); $i++) {
        if (!empty($arrIdsEstoque[$i])) {
            $qtd = intval($arrQtds[$i]);
            $val = floatval($arrValores[$i]);
            $somaValoresPecas += ($val * $qtd);

            if (!empty($arrPecas[$i])) {
                $nomesPecasArray[] = $arrPecas[$i];
            }
        }
    }

    $total = $somaValoresPecas + $maoObra;

    // Definição do texto descritivo para a coluna 'peca' na tabela orcamento
    if (count($nomesPecasArray) > 1) {
        $textoPecaTabelaOrcamento = "Múltiplas Peças";
    } elseif (count($nomesPecasArray) === 1) {
        $textoPecaTabelaOrcamento = mysqli_real_escape_string($conn, $nomesPecasArray[0]);
    } else {
        $textoPecaTabelaOrcamento = "Nenhuma peça";
    }

    // CORREÇÃO: Salvando $textoPecaTabelaOrcamento (string) ao invés do $arrPecas (Array)
    $sqlOrcamento = "INSERT INTO orcamento (diagnostico, peca, valorUni, maoObra, valorTotal, status, Cliente_idCliente, Aparelho_idAparelho, dataOrcamento) 
                     VALUES ('$diagnostico', '$textoPecaTabelaOrcamento', '$somaValoresPecas', '$maoObra', '$total', '$status', '$cliente', '$aparelho', NOW())";
    
    if (mysqli_query($conn, $sqlOrcamento)) {
        $idOrcamentoCriado = mysqli_insert_id($conn);

        // 2. Itera gravando os itens vinculados ao estoque físico na tabela orcamento_peca
        for ($i = 0; $i < count($arrIdsEstoque); $i++) {
            $idEstoque = !empty($arrIdsEstoque[$i]) ? intval($arrIdsEstoque[$i]) : null;
            
            if ($idEstoque) {
                $valUnitario = floatval($arrValores[$i]);
                $quantidade = intval($arrQtds[$i]);
                $totalItem = $valUnitario * $quantidade;

                // Recupera o nome correto da peça vinda do estoque
                $nomePeca = "Peça não identificada";
                $buscaNome = mysqli_query($conn, "SELECT peca FROM estoque WHERE idEstoque = $idEstoque");
                if ($resNome = mysqli_fetch_assoc($buscaNome)) {
                    $nomePeca = mysqli_real_escape_string($conn, $resNome['peca']);
                }

                $sqlPeca = "INSERT INTO orcamento_peca (Orcamento_idOrcamento, Estoque_idEstoque, peca, quantidade, valorUnitario, total) 
                            VALUES ($idOrcamentoCriado, $idEstoque, '$nomePeca', $quantidade, $valUnitario, $totalItem)";
                    
                mysqli_query($conn, $sqlPeca);
            }
        }
    } else {
        // Se der erro na query principal, mostra para depuração
        echo "Erro ao cadastrar orçamento: " . mysqli_error($conn);
        exit;
    }
}

mysqli_close($conn); 
header("location:../orcamentos.php");
exit();
?>