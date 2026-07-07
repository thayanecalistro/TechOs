<?php
include("conexao.php");

$opcao = $_GET['opcao'];

if ($opcao == 'I') {
    $cliente = $_POST['Cliente_idCliente'];
    $aparelho = $_POST['Aparelho_idAparelho'];
    $diagnostico = mysqli_real_escape_string($conn, $_POST['nDiagnostico']);
    $maoObra = floatval($_POST['nMaoObra']);
    $status = $_POST['nStatus']; 
    $total = floatval($_POST['nTotal']);

    $arrPecas = $_POST['nPeca'];
    $arrValores = $_POST['nValorUni'];
    $arrQtds = $_POST['nQtd'];

    $somaValoresPecas = 0;
    for ($i = 0; $i < count($arrPecas); $i++) {
        if (!empty($arrPecas[$i])) {
            $somaValoresPecas += (floatval($arrValores[$i]) * intval($arrQtds[$i]));
        }
    }

    $total = $somaValoresPecas + $maoObra;

    // 1. Grava o cabeçalho do orçamento na tabela principal
    $sqlOrcamento = "INSERT INTO orcamento (diagnostico, peca, valorUni, maoObra, valorTotal, status, Cliente_idCliente, Aparelho_idAparelho, dataOrcamento) 
                     VALUES ('$diagnostico', 'Múltiplas Peças', '$somaValoresPecas', '$maoObra', '$total', '$status', '$cliente', '$aparelho', NOW())";
    
    // ... (Código anterior de gravação do orçamento pai permanece idêntico)

    if (mysqli_query($conn, $sqlOrcamento)) {
        $idOrcamentoCriado = mysqli_insert_id($conn);

        // Listas vindas do formulário atualizado
        $arrIdsEstoque = $_POST['nIdEstoque'];
        $arrValores = $_POST['nValorUni'];
        $arrQtds = $_POST['nQtd'];

        // 2. Itera gravando os itens vinculados ao estoque físico
        for ($i = 0; $i < count($arrIdsEstoque); $i++) {
            $idEstoque = !empty($arrIdsEstoque[$i]) ? intval($arrIdsEstoque[$i]) : "NULL";
            $valUnitario = floatval($arrValores[$i]);
            $quantidade = intval($arrQtds[$i]);
            $totalItem = $valUnitario * $quantidade;

            // Recupera o nome correto da peça vinda do estoque para salvar o histórico nominal
            $nomePeca = "Peça não identificada";
            if ($idEstoque !== "NULL") {
                $buscaNome = mysqli_query($conn, "SELECT peca FROM estoque WHERE idEstoque = $idEstoque");
                if($resNome = mysqli_fetch_assoc($buscaNome)){
                    $nomePeca = mysqli_real_escape_string($conn, $resNome['peca']);
                }
            }

            // QUERY PERFEITA: Salvando agora com o ID do Estoque real!
            $sqlPeca = "INSERT INTO orcamento_peca (Orcamento_idOrcamento, Estoque_idEstoque, peca, quantidade, valorUnitario, total) 
                        VALUES ($idOrcamentoCriado, $idEstoque, '$nomePeca', $quantidade, $valUnitario, $totalItem)";
                
            mysqli_query($conn, $sqlPeca);
        }
    }
}

mysqli_close($conn); 
header("location:../orcamentos.php");
exit();
?>