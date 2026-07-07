<?php
// php/salvarEstoque.php
require_once('conexao.php'); 
require_once('funcaoEstoque.php'); 

// Se for envio do formulário via link (Excluir)
if (isset($_GET['excluir_id'])){
    $dados = [
        'idEstoque' => intval($_GET['excluir_id'])
    ];
    $resposta = funcaoestoque($conn, 'excluir', $dados);
    if($resposta['status'] == 'sucesso'){
        header("Location: ../estoque.php?sucesso=excluido");
    } else {
        echo "Erro ao Excluir: " . $resposta['mensagem'];
    }
    exit;
}

// Se for envio do formulário do Modal (Inserir ou Editar)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idEstoque = isset($_POST['idEstoque']) ? trim($_POST['idEstoque']) : '';

    if (!empty($idEstoque)) {
        $acao = 'editar'; // Corrigido: adicionado ponto e vírgula aqui!
    } else {
        $acao = 'inserir';
    }
    
    // Corrigido: adicionado o $ que faltava na variável $resposta
    $resposta = funcaoestoque($conn, $acao, $_POST);
    
    if ($resposta['status'] == 'sucesso') {
        header("Location: ../estoque.php?sucesso=" . $acao);
    } else {
        echo "Erro ao salvar dados: " . $resposta['mensagem'];
    }
    exit;    
}
?>