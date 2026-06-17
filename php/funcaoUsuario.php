<?php

function fotoUsuario($id){

$resp = "";

include("conexao.php");
$sql = "SELECT Foto FROM funcionario WHERE idFuncionario = $id;";        
$result = mysqli_query($conn,$sql);
mysqli_close($conn);

//Validar se tem retorno do BD
if (mysqli_num_rows($result) > 0) {
            
    $array = array();
    
    while ($linha = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        array_push($array,$linha);
    }
    
    foreach ($array as $coluna) {            
        //***Verificar os dados da consulta SQL
        $resp = $coluna["Foto"];
    }        
} 

return $resp;
}

//Função para buscar o nome do usuário
function nomeUsuario($id){

$resp = "";

include("conexao.php");
$sql = "SELECT nomeFuncionario FROM funcionario WHERE idFuncionario = $id;";        
$result = mysqli_query($conn,$sql);
mysqli_close($conn);

//Validar se tem retorno do BD
if (mysqli_num_rows($result) > 0) {
            
    $array = array();
    
    while ($linha = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        array_push($array,$linha);
    }
    
    foreach ($array as $coluna) {            
        //***Verificar os dados da consulta SQL
        $resp = $coluna["nomeFuncionario"];
    }        
} 

return $resp;
}

?>