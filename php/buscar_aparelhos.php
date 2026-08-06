<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

include("../includes/conexao.php"); 

if (isset($_GET['idCliente']) && !empty($_GET['idCliente'])) {
    $cliente_id = intval($_GET['idCliente']);

    if (!$conn) {
        echo "<option value=''>Erro: Falha na conexao com o Banco de Dados</option>";
        exit;
    }

    $sql = "SELECT a.idAparelho, m.nomeMarca, mo.nomeModelo
            FROM aparelho a
            LEFT JOIN modelo mo ON a.Modelo_idModelo = mo.idModelo
            LEFT JOIN marca m ON mo.Marca_idMarca = m.idMarca
            WHERE a.Cliente_idCliente = ?";

    $stmt = mysqli_prepare($conn, $sql);
    
    if (!$stmt) {
        echo "<option value=''>Erro na Query SQL: " . htmlspecialchars(mysqli_error($conn)) . "</option>";
        exit;
    }

    mysqli_stmt_bind_param($stmt, "i", $cliente_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        echo "<option value=''>Selecione o aparelho...</option>";
        while ($row = mysqli_fetch_assoc($result)) {
            $marca = !empty($row['nomeMarca']) ? $row['nomeMarca'] : 'Marca N/I';
            $modelo = !empty($row['nomeModelo']) ? $row['nomeModelo'] : 'Modelo N/I';
            $label = $marca . " " . $modelo;

            if (!empty($row['imeiAparelho'])) {
                $label .= " (IMEI: " . $row['imeiAparelho'] . ")";
            }
            echo "<option value='" . $row['idAparelho'] . "'>" . htmlspecialchars($label, ENT_QUOTES, 'UTF-8') . "</option>";
        }
    } else {
        echo "<option value=''>Nenhum aparelho cadastrado para este cliente (ID: $cliente_id)</option>";
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
} else {
    echo "<option value=''>Erro: idCliente nao enviado via GET</option>";
}
?>