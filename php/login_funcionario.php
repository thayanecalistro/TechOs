<?php
//dados no banco
$login = $_POST["nLogin"];
$senha = $_POST["nSenha"];

//comando sql

$sql = "SELECT * FROM funcionario
        WHERE login = '$login'
        AND senha = '$senha';";

//conectar no banco
include("conexao.php");

//executar o banco 
$result = mysqli_query ($conn,$sql);

//encerar conexão 
mysqli_close($conn); 

//Tratar o retorno
if (mysqli_num_rows($result)> 0 ){
    header("location:../sidebar.php");
} else {
    header("location:../");
}

?>