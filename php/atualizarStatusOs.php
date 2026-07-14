<?php
// php/atualizarStatusOs.php
include("/includes/conexao.php");

if (isset($_GET['id']) && isset($_GET['status'])) {
    $idOS = intval($_GET['id']);
    $status = mysqli_real_escape_string($conn, $_GET['status']);

    // Se o status for "finalizado", definimos a data de fechamento da OS como AGORA (NOW())
    // Caso contrário, deixamos a data de fechamento zerada/nula
    $sqlFechamento = "";
    if (strtolower($status) == 'finalizado') {
        $sqlFechamento = ", fechamentoOS = NOW()";
    } else {
        $sqlFechamento = ", fechamentoOS = NULL";
    }

    $sql = "UPDATE os SET 
                status = '$status' 
                $sqlFechamento 
            WHERE idOS = $idOS";

    if (mysqli_query($conn, $sql)) {
        // Redireciona de volta para a tela de OS com mensagem de sucesso
        header("Location: ../os.php?mensagem=status_atualizado");
    } else {
        echo "Erro ao atualizar status: " . mysqli_error($conn);
    }
} else {
    header("Location: ../os.php");
}

mysqli_close($conn);
exit();
?>