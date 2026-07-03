<?php
include("conexao.php"); // Certifique-se de que o caminho da conexão está correto

if (isset($_GET['cliente_id']) && !empty($_GET['cliente_id'])) {
    $cliente_id = intval($_GET['cliente_id']);

    // Query unindo aparelho, marca e modelo para trazer um nome descritivo bonito
    $sql = "SELECT a.idAparelho, m.nomeMarca, mo.nomeModelo, a.imeiAparelho 
            FROM aparelho a
            INNER JOIN modelo mo ON a.Modelo_idModelo = mo.idModelo
            INNER JOIN marca m ON mo.Marca_idMarca = m.idMarca
            WHERE a.Cliente_idCliente = ?";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $cliente_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        echo "<option value=''>Selecione o aparelho...</option>";
        while ($row = mysqli_fetch_assoc($result)) {
            $label = $row['nomeMarca'] . " " . $row['nomeModelo'];
            //if (!empty($row['imeiAparelho'])) {
            //    $label .= " (IMEI: " . $row['imeiAparelho'] . ")";
            //}
            echo "<option value='" . $row['idAparelho'] . "'>" . htmlspecialchars($label, ENT_QUOTES, 'UTF-8') . "</option>";
        }
    } else {
        echo "<option value=''>Nenhum aparelho cadastrado para este cliente</option>";
    }

    mysqli_close($conn);
} else {
    echo "<option value=''>Selecione primeiro o cliente...</option>";
}
?>