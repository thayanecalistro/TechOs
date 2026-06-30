<?php
// salvarEstoque.php
require_once('includes/conexao.php');
require_once('funcao_estoque.php'); 

// Se for envio do formulário do Modal (Inserir ou Editar)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['NomeFornecedor'])) {
    $acao = (!empty($_POST['idEstoque'])) ? 'editar' : 'inserir';
    $resposta = funcaoestoque($conn, $acao, $_POST);
    
    echo "<script>alert('".$resposta['mensagem']."'); window.location.href='estoque.php';</script>";
    exit;
}

// Se for clique no botão Excluir (via GET)
if (isset($_GET['excluir_id'])) {
    $resposta = funcaoestoque($conn, 'excluir', ['idEstoque' => $_GET['excluir_id']]);
    
    echo "<script>alert('".$resposta['mensagem']."'); window.location.href='estoque.php';</script>";
    exit;
}

// Segurança: Se tentarem acessar este arquivo de fora, joga pro estoque
header("Location: estoque.php");
exit;
?>