<?php
    $opcao = $_GET['opcao'] ?? null;
    $id = $_GET['id'] ?? null;
    $cliente = $_POST['nCliente'] ?? null;
    $marca = $_POST['nMarca'] ?? null;
    $modeloNome = $_POST['nModelo'] ?? null;
    $imei = $_POST['nImei'] ?? null;

    include("funcoes.php");
    // CORREÇÃO: Ajustado caminho do include para a mesma pasta
    include("php/conexao.php"); 

    $idModelo = null;

    if (($opcao == 'I' || $opcao == 'U') && !empty($modeloNome)) {
        $modeloNomeClean = mysqli_real_escape_string($conn, trim($modeloNome));
        
        $sqlCheck = "SELECT idModelo FROM modelo WHERE nomeModelo = '$modeloNomeClean'";
        $resCheck = mysqli_query($conn, $sqlCheck);

        if ($resCheck && mysqli_num_rows($resCheck) > 0) {
            $row = mysqli_fetch_assoc($resCheck);
            $idModelo = $row['idModelo'];
        } else {
            // Se o modelo não existir, tenta inserir baseado na estrutura da tabela modelo
            $sqlInsModelo = "INSERT INTO modelo (nomeModelo, Marca_idMarca) VALUES ('$modeloNomeClean', '$marca')";
            mysqli_query($conn, $sqlInsModelo);
            $idModelo = mysqli_insert_id($conn);
        }
    }

    $sql = "";

    if($opcao == 'I'){
        $sql = "INSERT INTO aparelho(Cliente_idCliente, Marca_idMarca, Modelo_idModelo, imeiAparelho, historicoAparelho)
                VALUES($cliente, '$marca', '$idModelo', '$imei', '');";

    } elseif ($opcao == 'U') {
        $sql = "UPDATE aparelho SET Cliente_idCliente = '$cliente',
                                   Marca_idMarca = '$marca',
                                   Modelo_idModelo = '$idModelo',
                                   imeiAparelho = '$imei'
                               WHERE idAparelho = $id;";

    } elseif($opcao == 'D'){    
        $sql = "DELETE FROM aparelho WHERE idAparelho = $id;"; }

    if (!empty($sql)) {
        $result = mysqli_query($conn, $sql);
    }
	
    mysqli_close($conn);

    // CORREÇÃO: Redireciona o usuário de volta para a tela de listagem de aparelhos
    header("Location: cadastroAparelho.php");
    exit();
?>