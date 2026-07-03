<?php
// salvarEstoque.php
require_once('includes/conexao.php');
require_once('funcao_estoque.php'); 

// Se for envio do formulário do Modal (Inserir ou Editar)
if (isset($_GET['excluir_id'])){
    $dados = [
        'idEstoque' => $_GET[excluir_id]
    ];
    $resposta = funcaoestoque($conn, 'excluir', $dados);
    if($resposta['status'] == 'sucesso'){
        header("Location: estoque.php?sucesso=excluido");
    }else{
        echo "Erro ao Excluir: ". $resposta['mensagem'];
    }
    exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idEstoque = isset($_POST['idEstoque']) ? trim($_POST['idEstoque']) : '';

    if(!empty($idEstoque)){
        $acao = 'Editar'
    }else{
        $acao = 'inserir';
    }
    resposta = funcaoestoque($conn, $acao, $_POST);
    if ($resposta['status'] == 'sucesso') {
        header("Location: estoque.php?sucesso=" .$acao);

    }else {
        echo "Erro ao salvar dados: " .$resposta['mensagem'];
    }
    exit;    
}
