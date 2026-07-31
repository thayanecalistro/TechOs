<?php

include("funcoes.php"); 

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
    $senha= isset($_POST['nSenha']) ? $_POST['nSenha'] : '';

    // ==========================================
    // TRATAMENTO DO UPLOAD DA FOTO (ADICIONADO)
    // ==========================================
    $caminhoFoto = null;
    if (isset($_FILES['nFoto']) && $_FILES['nFoto']['error'] === UPLOAD_ERR_OK) {
        $extensao = strtolower(pathinfo($_FILES['nFoto']['name'], PATHINFO_EXTENSION));
        $novoNome = uniqid("func_") . "." . $extensao;
        $pastaDestino = "../img/";

        if (!is_dir($pastaDestino)) {
            mkdir($pastaDestino, 0777, true);
        }

        if (move_uploaded_file($_FILES['nFoto']['tmp_name'], $pastaDestino . $novoNome)) {
            $caminhoFoto = "img/" . $novoNome;
        }
    }

     if ($opcao == "I"){

         $sql = "INSERT INTO funcionario (tipoFuncionario, nomeFuncionario, cpfFuncionario, emailFuncionario, telefoneFuncionario, cepFuncionario, enderecoFuncionario, numeroFuncionario, complementoFuncionario, bairroFuncionario, cidadeFuncionario, estadoFuncionario, login, senha, foto)
         VALUES ('$tipo', '$nome', '$cpf', '$email', '$telefone', '$cep',  '$endereco', '$numero', '$complemento', '$bairro', '$cidade', '$estado', '$login', '$senha', '$caminhoFoto');";

     } elseif ($opcao == "U"){
       
        $sql="UPDATE funcionario SET 
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
              senha = '$senha'";

        // Se o usuário selecionou uma NOVA foto ao alterar, atualiza a fotoFuncionario no banco
        if ($caminhoFoto) {
          $sql .= ", foto = '$caminhoFoto'";
        }

        $sql .=" WHERE idFuncionario = '$id';";

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