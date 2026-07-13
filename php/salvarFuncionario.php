<?php

include("funcoes.php"); 

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_GET['opcao']) && $_GET['opcao'] == 'I') {
    
    
    $tipo= $_POST['nTipo'];
    $nome= $_POST['nNome'];
    $cpf= $_POST['nCpf'];
    $email= $_POST['nEmail'];
    $telefone= $_POST['nTelefone'];
    $endereco= $_POST['nEndereco'];
    $login= $_POST['nLogin'];
    
    // Segurança: Criptografa a senha antes de enviar ao Banco de dados
    $senha_limpa = $_POST['nSenha'];
    $senha_hash  = password_hash($senha_limpa, PASSWORD_DEFAULT);

    // Trata o upload da foto se houver
    $nome_foto = NULL;
    if (isset($_FILES['nFoto']) && $_FILES['nFoto']['error'] == 0) {
        $extensao = pathinfo($_FILES['nFoto']['name'], PATHINFO_EXTENSION);
        $nome_foto = uniqid() . "." . $extensao;
        move_uploaded_file($_FILES['nFoto']['tmp_name'], "../img/funcionarios/" . $nome_foto);
    }

     // Pronto para descomentar e rodar após adaptar à sua variável de conexão ($conexao)
    $sql = "INSERT INTO funcionario (tipoFuncionario, nomeFuncionario, cpfFuncionario, emailFuncionario, telefoneFuncionario, enderecoFuncionario, login, senha, foto) 
            VALUES ('$tipo', '$nome', '$cpf', '$email', '$telefone', '$endereco', '$login', '$senha_hash', '$nome_foto')";
    
    include ("includes/conexao.php");


    $result = mysqli_query($conn,$sql);

    //fechar banco 
    mysqli_close($conn);
    
    
    // Redirecionamento de teste temporário
    header("Location: ../funcionarios.php");
    exit();
}
?>