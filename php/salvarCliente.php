<?php

$opcao = $_GET['opcao'];

$id = isset( $_POST['nIdCliente']) ? $_POST['nIdCliente'] : (isset( $_GET['nIdCliente']) ? $_GET['nIdCliente'] : null) ; 
$nome = isset($_POST['nNome']) ? $_POST['nNome'] : '' ;
$cpf = isset($_POST['nCpf']) ? $_POST['nCpf'] : '';
$telefone = isset($_POST['nTelefone']) ? $_POST['nTelefone'] : '';
$cep = isset($_POST['nCep']) ? $_POST['nCep'] : '' ;
$endereco =isset($_POST['nEndereco']) ? $_POST['nEndereco'] : '';
$numero = isset($_POST['nNumero']) ? $_POST['nNumero'] : '';
$complemento = isset($_POST['nComplemento']) ? $_POST['nComplemento'] : '';
$bairro = isset($_POST['nBairro']) ? $_POST['nBairro'] : '' ;
$cidade = isset($_POST['nCidade']) ? $_POST['nCidade'] :'' ;
$estado= isset($_POST['nEstado']) ? $_POST['nEstado'] : '' ;

if ($opcao == 'I'){

  $sql = "INSERT INTO clientes (nomeCliente, cpfCliente, telefoneCliente, cepCliente, enderecoCliente, numeroCliente, complementoCliente, bairroCliente, cidadeCliente, estadoCliente)
  VALUES ('$nome', '$cpf', '$telefone', '$cep',  '$endereco', '$numero', '$complemento', '$bairro', '$cidade', '$estado');";

}elseif ($opcao == "D"){

$sql = "DELETE FROM clientes WHERE idCliente = '$id';"; 

}elseif ($opcao == "U"){

 $sql = "UPDATE clientes SET 
            nomeCliente = '$nome', 
            cpfCliente = '$cpf', 
            telefoneCliente = '$telefone', 
            cepCliente = '$cep', 
            enderecoCliente = '$endereco', 
            numeroCliente = '$numero', 
            complementoCliente = '$complemento', 
            bairroCliente = '$bairro', 
            cidadeCliente = '$cidade', 
            estadoCliente = '$estado' 
            WHERE idCliente = '$id';";
         
}

//conectar banco 
include ("conexao.php");
if (mysqli_query($conn,$sql)){
  mysqli_close($conn);

  header("Location: ../cliente.php");
  exit();

}  else {
   echo "Erro ao processar requisição: " . mysqli_error($conn);
   mysqli_close($conn);
}
?>