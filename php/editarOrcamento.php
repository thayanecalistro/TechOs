<?php
// php/editarOrcamento.php
include("includes/conexao.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_GET['id'])) {
    $idOrcamento = intval($_GET['id']);
    
    // Captura campos de texto
    $diagnostico = isset($_POST['nDiagnostico']) ? mysqli_real_escape_string($conn, $_POST['nDiagnostico']) : '';
    $status = isset($_POST['nStatus']) ? mysqli_real_escape_string($conn, $_POST['nStatus']) : '';
    
    // Captura campos numéricos usando os 'names' corretos do orcamentos.php
    $maoObra = isset($_POST['nMaoObra']) ? floatval($_POST['nMaoObra']) : 0.0;
    
    // Recebe as informações do array de peças para calcular os totais
    $arrPecas = $_POST['nPeca'] ?? [];
    $arrIdsEstoque = $_POST['nIdEstoque'] ?? [];
    $arrValores = $_POST['nValorUni'] ?? [];
    $arrQtds = $_POST['nQtd'] ?? [];

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

    // Calcula o valor total final (Mão de Obra + Peças)
    $total = $somaValoresPecas + $maoObra;

    // Define o texto amigável do campo 'peca' na tabela principal
    if (count($nomesPecasArray) > 1) {
        $textoPecaTabelaOrcamento = "Múltiplas Peças";
    } elseif (count($nomesPecasArray) === 1) {
        $textoPecaTabelaOrcamento = mysqli_real_escape_string($conn, $nomesPecasArray[0]);
    } else {
        $textoPecaTabelaOrcamento = "Nenhuma peça";
    }

    $updateStatusSql = "";
    if(!empty($status)) {
        $updateStatusSql = ", status = '$status'";
    }

    // 1. Executa o UPDATE na tabela principal 'orcamento'
    $sql = "UPDATE orcamento SET 
                diagnostico = '$diagnostico', 
                valorUni = '$somaValoresPecas',
                maoObra = '$maoObra', 
                valorTotal = '$total',
                peca = '$textoPecaTabelaOrcamento'
                $updateStatusSql
            WHERE idOrcamento = $idOrcamento";

    $resultado = mysqli_query($conn, $sql);

    // 2. Reconstrói a tabela intermediária 'orcamento_peca'
    if ($resultado) {
        // Limpa os registros anteriores das peças deste orçamento
        mysqli_query($conn, "DELETE FROM orcamento_peca WHERE Orcamento_idOrcamento = $idOrcamento");

        // Insere as peças atualizadas
        for ($i = 0; $i < count($arrIdsEstoque); $i++) {
            $idEstoque = !empty($arrIdsEstoque[$i]) ? intval($arrIdsEstoque[$i]) : null;
            
            if ($idEstoque) {
                $valUnitario = floatval($arrValores[$i]);
                $quantidade = intval($arrQtds[$i]);
                $totalItem = $valUnitario * $quantidade;

                // Recupera o nome correto da peça no estoque
                $nomePeca = "Peça não identificada";
                $buscaNome = mysqli_query($conn, "SELECT peca FROM estoque WHERE idEstoque = $idEstoque");
                if ($resNome = mysqli_fetch_assoc($buscaNome)) {
                    $nomePeca = mysqli_real_escape_string($conn, $resNome['peca']);
                }

                $sqlPeca = "INSERT INTO orcamento_peca (Orcamento_idOrcamento, Estoque_idEstoque, peca, quantidade, valorUnitario, total) 
                            VALUES ($idOrcamento, $idEstoque, '$nomePeca', $quantidade, $valUnitario, $totalItem)";
                    
                mysqli_query($conn, $sqlPeca);
            }
        }

        // =========================================================================
        // 3. SINCRONIZAÇÃO AUTOMÁTICA DA ORDEM DE SERVIÇO (OS)
        // =========================================================================
        
        // Verifica se esse orçamento já possui uma OS vinculada
        $sqlVerificaOS = "SELECT OS_idOS FROM orcamento WHERE idOrcamento = $idOrcamento";
        $buscaOS = mysqli_query($conn, $sqlVerificaOS);
        
        if ($resOS = mysqli_fetch_assoc($buscaOS)) {
            $idOS = $resOS['OS_idOS'];

            if (!empty($idOS)) {
                // Se o orçamento já tem uma OS associada, atualizamos os valores nela
                $novaDescricao = "OS automática gerada a partir do Orçamento número #$idOrcamento. Diagnóstico: " . $diagnostico;
                
                $sqlAtualizarOS = "UPDATE os SET 
                                    descricaoOS = '$novaDescricao', 
                                    valorOS = '$total' 
                                   WHERE idOS = $idOS";
                
                mysqli_query($conn, $sqlAtualizarOS);
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
?>