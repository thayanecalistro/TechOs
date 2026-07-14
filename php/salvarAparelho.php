<?php

    $opcao = $_GET['opcao'] ?? null;
    $id = $_POST['idAparelho'] ?? $_GET['id'] ?? null; // Ajustado para pegar do formulário de Alterar também
    $cliente = $_POST['nCliente'] ?? null;
    $marca = $_POST['nMarca'] ?? null;
    $modeloNome = $_POST['nModelo'] ?? null;
    $imei = $_POST['nImei'] ?? null;
    
    include("includes/conexao.php"); 

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
            // Se o modelo não existir, tenta inserir baseado na estrutura da tabela modelo
            $sqlInsModelo = "INSERT INTO modelo (nomeModelo, Marca_idMarca) VALUES ('$modeloNomeClean', $marcaClean)";
            mysqli_query($conn, $sqlInsModelo);
            $idModelo = mysqli_insert_id($conn);
        }
    }

    $sql = "";

    $cliente = intval($cliente);
    $idModelo = intval($idModelo);
    $id = intval($id);

    if($opcao == 'I'){
        $sql = "INSERT INTO aparelho(Cliente_idCliente, Modelo_idModelo, imeiAparelho, historicoAparelho)
                VALUES($cliente, '$idModelo', '$imei', '');";

    } elseif ($opcao == 'U' && $id > 0) {
        $sql = "UPDATE aparelho SET Cliente_idCliente = '$cliente',
                                   Modelo_idModelo = '$idModelo',
                                   imeiAparelho = '$imei'
                               WHERE idAparelho = $id;";

    } elseif($opcao == 'D' && $id > 0){    
        $sql = "DELETE FROM aparelho WHERE idAparelho = $id";}

    if (!empty($sql)) {
        $result = mysqli_query($conn, $sql);
    }
	
    mysqli_close($conn);

    header("Location: ../cadastroAparelho.php");
    exit();
?>