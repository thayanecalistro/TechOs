<?php
 include('funcaoCliente.php');
 include('funcaoAparelho.php');
 include ('funcaoFuncionario.php'); 
 include ('funcaoOrcamento.php');
 include_once("funcaoEstoque.php");
 include ('funcaoOs.php');

function listaAparelhosGeral(){
    $html = "";

    // SQL com INNER JOIN usando as chaves estrangeiras exatas das suas imagens
    $sql = "SELECT a.idAparelho, c.nomeCliente, m.nomeMarca, a.Modelo_idModelo, a.imeiAparelho, a.historicoAparelho 
            FROM aparelho a
            INNER JOIN clientes c ON a.Cliente_idCliente = c.idCliente
            INNER JOIN marca m ON a.Marca_idMarca = m.idMarca
            ORDER BY a.idAparelho DESC";

    include("includes/conexao.php");
    $result = mysqli_query($conn, $sql);
    mysqli_close($conn);

    if($result && mysqli_num_rows($result) > 0){
        foreach($result as $coluna){
            $html .= "<tr>
                          <td>#".$coluna['idAparelho']."</td>
                          <td>".$coluna['nomeCliente']."</td>
                          <td>".$coluna['nomeMarca']."</td>
                          <td>ID: ".$coluna['Modelo_idModelo']."</td>
                          <td>".$coluna['imeiAparelho']."</td>
                          <td>".htmlspecialchars($coluna['historicoAparelho'])."</td>
                     </tr>";
        }
    } else {
        $html .= "<tr><td colspan='6' style='text-align:center;'>Nenhum aparelho cadastrado no momento.</td></tr>";
    }

    return $html;
}

