<?php

    $opcao = $_GET['opcao'];
    $id = $_GET['id'] ?? null;
    $cliente = $_POST['nCliente'] ?? null;
    $marca = $_POST['nMarca'] ?? null;
    $modelo = $_POST['nModelo'] ?? null;
    $imei = $_POST['nImei'] ?? null;

    include ('funcoes.php');

    //montar sql
    if($opcao == 'I'){
        
        $sql = "INSERT INTO aparelho(Cliente_idCliente, Marca_idMarca, Modelo_idModelo, imeiAparelho)
                VALUES($cliente, '$marca', '$modelo', '$imei');";

    }elseif ($opcao == 'U') {
        //echo "VAI RODAR UM UPDATE";
        
        $sql = "UPDATE aparelho SET Cliente_idCliente ='$cliente',
                                   Marca_idMarca ='$marca',
                                   Modelo_idModelo ='$modelo',
                                   imeiAparelho = '$imei'
                               WHERE idAparelho = $id;";

    }elseif($opcao == 'D'){
        //echo " VAI RODAR UM DELETE";
        $sql ="DELETE FROM aparelho 
               WHERE idAparelho= $id;";
    }

    	//Conectar
	include("conexao.php");

	//Executar
	$result = mysqli_query($conn,$sql);
	
	//Encerro conexão
	mysqli_close($conn);

?>