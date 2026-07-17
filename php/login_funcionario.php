<?php

session_start();
//dados no banco
$login = $_POST["nLogin"];
$senha = $_POST["nSenha"];
//comando sql

$sql = "SELECT idFuncionario, tipoFuncionario, nomeFuncionario FROM funcionario
        WHERE login = '$login'
        AND senha = '$senha'
        LIMIT 1;";


include ("../includes/conexao.php");

$resultado= mysqli_query($conn, $sql); 

if ($resultado){
    if (mysqli_num_rows($resultado)== 1){
      $coluna = mysqli_fetch_assoc($resultado);

      $_SESSION['idFuncionario'] = $coluna ['idFuncionario'];
      $_SESSION['tipoFuncionario'] = $coluna ['tipoFuncionario'];
      $_SESSION['nomeFuncionario'] = $coluna ['nomeFuncionario'];
      
      mysqli_close($conn);

      header("Location: ../dashboard.php");
      exit();
    } else {
      mysqli_close($conn);
        header("Location: ../index.php?erro=dados_invalidos");
        exit();
    }
  } else {
     echo "Erro ao processar requisição: " . mysqli_error($conn);
    mysqli_close($conn);
}

?>