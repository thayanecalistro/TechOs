<?php

include("funcoes.php"); 
include("../includes/conexao.php");

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

    $opcao= $_GET['opcao'];

    $id = isset($_POST['idFuncionario']) ? $_POST['idFuncionario'] : (isset($_GET['idFuncionario']) ? $_GET['idFuncionario'] : null);
    $tipo= isset($_POST['nTipo']) ? $_POST['nTipo'] : '';
    $nome= isset($_POST['nNome']) ? $_POST['nNome'] : '';
    $cpf= isset($_POST['nCpf']) ? $_POST['nCpf'] : '';
    $email= isset($_POST['nEmail']) ? $_POST['nEmail'] : '';
    $telefone= isset($_POST['nTelefone']) ? $_POST['nTelefone'] : '';
    $cep= isset($_POST['nCep']) ? $_POST['nCep'] : ''; 
    $endereco= isset($_POST['nEndereco']) ? $_POST['nEndereco'] : '' ;
    $numero= isset($_POST['nNumero']) ? $_POST['nNumero'] : '';
    $complemento= isset($_POST['nComplemento']) ? $_POST['nComplemento'] : '';
    $bairro= isset($_POST['nBairro']) ? $_POST['nBairro'] : '';
    $cidade= isset($_POST['nCidade']) ? $_POST['nCidade'] : '' ;
    $estado= isset($_POST['nEstado']) ? $_POST['nEstado'] : '';
    $login= isset($_POST['nLogin']) ? $_POST['nLogin'] : '';
    $senhaInput= isset($_POST['nSenha']) ? $_POST['nSenha'] : '';
    $novaFoto = false;
    $nomeFoto = "padrao.png";

    if (isset($_FILES['nFoto']) && $_FILES['nFoto']['error'] === UPLOAD_ERR_OK) {
    $extensao = strtolower(pathinfo($_FILES['nFoto']['name'], PATHINFO_EXTENSION));
    $extensoesPermitidas = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

    if (in_array($extensao, $extensoesPermitidas)) {
        // Gera um nome único para o arquivo
        $nomeFoto = "func_" . uniqid() . "." . $extensao;
        $diretorioDestino = "../img/usuarios/" . $nomeFoto;

        // Cria a pasta se ela não existir
        if (!is_dir("../img/usuarios")) {
            mkdir("../img/usuarios", 0777, true);
        }

        // Tenta mover o arquivo enviado para a pasta
        if (move_uploaded_file($_FILES['nFoto']['tmp_name'], $diretorioDestino)) {
            $novaFoto = true;
        } else {
            // Se falhar o upload físico, reverte para o nome padrão
            $nomeFoto = "padrao.png";
        }
    }
}
 

     if ($opcao == "I"){

     $senhaHash = md5($senhaInput);

         $sql = "INSERT INTO funcionario (tipoFuncionario, nomeFuncionario, cpfFuncionario, emailFuncionario, telefoneFuncionario, cepFuncionario, enderecoFuncionario, numeroFuncionario, complementoFuncionario, bairroFuncionario, cidadeFuncionario, estadoFuncionario, login, senha, fotoFuncionario)
         VALUES ('$tipo', '$nome', '$cpf', '$email', '$telefone', '$cep',  '$endereco', '$numero', '$complemento', '$bairro', '$cidade', '$estado', '$login', '$senhaHash', '$nomeFoto');";

     } elseif ($opcao == "U"){
       
      $senhaFinal = "";
    $sqlBusca = "SELECT senha FROM funcionario WHERE idFuncionario = '$id' LIMIT 1";
    $resBusca = mysqli_query($conn, $sqlBusca);

    if ($resBusca && $row = mysqli_fetch_assoc($resBusca)) {
        $senhaAtualBanco = $row['senha'];
        
        // Se a senha enviada do formulário for diferente da do banco (ou não for um hash MD5 de 32 chars), criptografa
        if ($senhaInput !== $senhaAtualBanco) {
            $senhaFinal = md5($senhaInput);
        } else {
            // Mantém a senha como já está no banco
            $senhaFinal = $senhaAtualBanco;
        }
    } else {
        $senhaFinal = md5($senhaInput);
    }

       if ($novaFoto) {
        $sql = "UPDATE funcionario SET 
              tipoFuncionario = '$tipo',
              nomeFuncionario = '$nome',
              cpfFuncionario = '$cpf',
              emailFuncionario = '$email',
              telefoneFuncionario = '$telefone',
              cepFuncionario = '$cep',
              enderecoFuncionario = '$endereco',
              numeroFuncionario = '$numero',
              complementoFuncionario = '$complemento',
              bairroFuncionario = '$bairro',
              cidadeFuncionario = '$cidade',
              estadoFuncionario = '$estado',
              login = '$login',
              senha = '$senhaFinal',
              fotoFuncionario = '$nomeFoto'
              WHERE idFuncionario = '$id';";

            if (isset($_SESSION['idFuncionario']) && $_SESSION['idFuncionario'] == $id) {
            $_SESSION['fotoFuncionario'] = $nomeFoto;
        }
    } else {
        // Atualiza mantendo a foto antiga
        $sql = "UPDATE funcionario SET 
              tipoFuncionario = '$tipo',
              nomeFuncionario = '$nome',
              cpfFuncionario = '$cpf',
              emailFuncionario = '$email',
              telefoneFuncionario = '$telefone',
              cepFuncionario = '$cep',
              enderecoFuncionario = '$endereco',
              numeroFuncionario = '$numero',
              complementoFuncionario = '$complemento',
              bairroFuncionario = '$bairro',
              cidadeFuncionario = '$cidade',
              estadoFuncionario = '$estado',
              login = '$login',
              senha = '$senhaFinal'
              WHERE idFuncionario = '$id';";
    }
     } elseif ($opcao == "D") {

       $sql = "DELETE FROM funcionario WHERE idFuncionario = '$id';";

     }

include ("../includes/conexao.php");
if (mysqli_query($conn,$sql)){
mysqli_close($conn);

header("Location: ../funcionario.php");
exit();

}  else {
echo "Erro ao processar requisição: " . mysqli_error($conn);
mysqli_close($conn);
}
?>