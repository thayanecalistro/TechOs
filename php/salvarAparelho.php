<?php

    $opcao = $_GET['opcao'];/*recebe na url*/
    $id = $_GET['id'] ?? null;
    $cliente = $_POST['nCliente'];/*isset() */
    $marca = $_POST['nMarca'];
    $modelo = $_POST['nModelo'];
    $imei = $_POST['nImei'];

    include ('funcoes.php');

   if ($_POST['nAtivo'] == 'on') $ativo = 'S'; else $ativo = 'N';

    //montar sql
    if($opcao == 'I'){
        $id = proximoID('aparelho','idAparelho');

        //echo "VAI RODAR UM INSERT";
        $sql = "INSERT INTO aparelho(idAparelho, Cliente_idCliente, Marca_idMarca, Modelo_idModelo, imeiAparelho)
                VALUES($id, $cliente, '$marca','$modelo','$imei');";

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