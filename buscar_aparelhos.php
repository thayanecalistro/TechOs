<?php
// buscar_aparelhos.php

if (isset($_GET['idCliente'])) {
    $idCliente = intval($_GET['idCliente']);
    
    // Conexão com o banco de dados
    include("includes/conexao.php");

    // SQL com INNER JOIN para pegar os nomes reais da marca e modelo do aparelho do cliente
    $sql = "SELECT a.idAparelho, m.nomeMarca, mo.nomeModelo 
            FROM aparelho a
            INNER JOIN marca m ON a.Marca_idMarca = m.idMarca
            INNER JOIN modelo mo ON a.Modelo_idModelo = mo.idModelo
            WHERE a.Clientes_idCliente = $idCliente
            ORDER BY m.nomeMarca ASC, mo.nomeModelo ASC";

    $result = mysqli_query($conn, $sql);
    mysqli_close($conn);

    $html = "<option value=''>Selecione o aparelho...</option>";

    if ($result && mysqli_num_rows($result) > 0) {
        while ($coluna = mysqli_fetch_assoc($result)) {
            $nomeCompleto = $coluna['nomeMarca'] . " " . $coluna['nomeModelo'];
            $html .= "<option value='" . $coluna['idAparelho'] . "'>" . $nomeCompleto . "</option>";
        }
    } else {
        $html .= "<option value=''>Nenhum aparelho cadastrado para este cliente</option>";
    }

    echo $html;
    exit;
}
?>