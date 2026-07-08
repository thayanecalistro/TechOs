<?php
// php/processarAcoes.php
include("funcoes.php"); // Certifique-se de que o caminho para o seu arquivo de funções está correto

if (isset($_GET['acao']) && $_GET['acao'] == 'excluir' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    // Chama a função que criamos
    $sucesso = excluirOrcamento($id);

    if ($sucesso) {
        // Redireciona de volta para a página de orçamentos com uma mensagem de sucesso
        header("Location: ../orcamentos.php?mensagem=excluido_com_sucesso");
    } else {
        header("Location: ../orcamentos.php?mensagem=erro_ao_excluir");
    }
    exit;
}
?>