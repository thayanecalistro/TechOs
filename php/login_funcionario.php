<?php

session_start();
//dados no banco
$login = $_POST["nLogin"];
$senha = $_POST["nSenha"];

//comando sql

$sql = "SELECT * FROM funcionario
        WHERE login = '$login'
        AND senha = '$senha';";

//conectar no banco
include("includes/conexao.php");

//executar o banco 
$result = mysqli_query ($conn,$sql);

//Tratar o retorno
if (mysqli_num_rows($result)> 0 ){
    $dados_funcionario = mysqli_fetch_assoc($result);

    $_SESSION['usuario_logado'] = $dados_funcionario['$login'];
    $_SESSION['nome_usuario'] = $dados_funcionario['nome'];
    
    //encerar conexão 
    mysqli_close($conn); 

    //redirecionamento
    header("location:../dashboard.php");
    exit();
} else {
    mysqli_close($conn);

    header("location:../index.php?erro=1");
    exit();
}
?>