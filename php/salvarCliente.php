<?php

$opcao = $_GET['opcao'];
$id = $_POST['nIdCliente']; 
$nome = $_POST['nNome'];
$cpf = $_POST['nCpf'];
$telefone = $_POST['nTelefone'];
$cep = $_POST['nCep'];
$endereco = $_POST['nEndereco'];
$numero = $_POST['nNumero'];
$complemento = $_POST['nComplemento'];
$bairro = $_POST['nBairro'];
$cidade = $_POST['nCidade'];
$estado= $_POST['nEstado'];

if ($opcao == 'I'){

  $sql = "INSERT INTO clientes (nomeCliente, cpfCliente, telefoneCliente, cepCliente, enderecoCliente, numeroCliente, complementoCliente, bairroCliente, cidadeCliente, estadoCliente)
  VALUES ('$nome', '$cpf', '$telefone', '$cep',  '$endereco', '$numero', '$complemento', '$bairro', '$cidade', '$estado');";

}elseif ($opcao == "D"){

$sql = "DELETE * FROM clientes WHERE idCliente = '$id';"; 

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
include ("includes/conexao.php");

// executar sql
$result = mysqli_query($conn,$sql);

//fechar banco 
mysqli_close($conn); 

//tratar o retorno
header("location:../cliente.php");
?>