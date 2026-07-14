<?php

session_start();
//dados no banco
$login = $_POST["nLogin"];
$senha = $_POST["nSenha"];

//comando sql

$sql = "SELECT * FROM funcionario
        WHERE login = '$login'
        AND senha = '$senha';";


include ("../includes/conexao.php");
if (mysqli_query($conn,$sql)){
  mysqli_close($conn);

  header("Location: ../dashboard.php");
  exit();

}  else {
   echo "Erro ao processar requisição: " . mysqli_error($conn);
   mysqli_close($conn);
}

?>