<?php
include_once("funcoes.php");

$opcao = $_GET['opcao'] ?? null;
$id = $_POST['idAparelho'] ?? $_GET['id'] ?? null; 

// CAPTURA CORRETA DO CAMPO ENVIADO PELO FORMULÁRIO (nCliente)
$cliente = $_POST['nCliente'] ?? null; 
$marca = $_POST['nMarca'] ?? null;
$modeloNome = $_POST['nModelo'] ?? null;
$imei = $_POST['nImei'] ?? null;

include("../includes/conexao.php"); 

$idModelo = null;

if (($opcao == 'I' || $opcao == 'U') && !empty($modeloNome)) {
    $modeloNomeClean = mysqli_real_escape_string($conn, trim($modeloNome));
    $marcaClean = intval($marca);
    
    $sqlCheck = "SELECT idModelo FROM modelo WHERE nomeModelo = '$modeloNomeClean' AND Marca_idMarca = $marcaClean";
    $resCheck = mysqli_query($conn, $sqlCheck);

    if ($resCheck && mysqli_num_rows($resCheck) > 0) {
        $row = mysqli_fetch_assoc($resCheck);
        $idModelo = $row['idModelo'];
    } else {
        $sqlInsModelo = "INSERT INTO modelo (nomeModelo, Marca_idMarca) VALUES ('$modeloNomeClean', $marcaClean)";
        mysqli_query($conn, $sqlInsModelo);
        $idModelo = mysqli_insert_id($conn);
    }
}

$clienteVal = intval($cliente);
$idModeloVal = intval($idModelo);
$idVal = intval($id);
$sql = "";

if ($opcao == 'I') {
    $sql = "INSERT INTO aparelho (Cliente_idCliente, Modelo_idModelo, imeiAparelho, historicoAparelho)
            VALUES ($clienteVal, $idModeloVal, '$imei', '');";

} elseif ($opcao == 'U' && $idVal > 0) {
    $sql = "UPDATE aparelho SET Cliente_idCliente = $clienteVal,
                               Modelo_idModelo = $idModeloVal,
                               imeiAparelho = '$imei'
                           WHERE idAparelho = $idVal;";

} elseif ($opcao == 'D' && $idVal > 0) {    
    $sql = "DELETE FROM aparelho WHERE idAparelho = $idVal;";
}

if (!empty($sql)) {
    if (mysqli_query($conn, $sql)) {
        // GRAVAÇÃO NO LOG DE AUDITORIA
        if ($opcao == 'I') {
            registrarLog('Novo Aparelho', 'Cadastrou o aparelho IMEI: ' . $imei);
        } elseif ($opcao == 'U') {
            registrarLog('Alteração de Aparelho', 'Atualizou o aparelho ID: #' . $idVal);
        } elseif ($opcao == 'D') {
            registrarLog('Exclusão de Aparelho', 'Excluiu o aparelho ID: #' . $idVal);
        }
    }
}


mysqli_close($conn);

header("Location: ../cadastroAparelho.php");
exit();
?>