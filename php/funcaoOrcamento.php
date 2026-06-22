<?php
function listaOrcamento(){
    $html = "";

    // INNER JOIN robusto associando as chaves estrangeiras reais das suas tabelas
    $sql = "SELECT o.idOrcamento, c.nomeCliente, m.nomeMarca, mo.nomeModelo, o.peca, o.valorUni, o.maoObra, o.valorTotal, o.status 
            FROM orcamento o
            INNER JOIN clientes c ON o.Cliente_idCliente = c.idCliente
            INNER JOIN aparelho a ON o.Aparelho_idAparelho = a.idAparelho
            INNER JOIN marca m ON a.Marca_idMarca = m.idMarca
            INNER JOIN modelo mo ON a.Modelo_idModelo = mo.idModelo";

    include("includes/conexao.php");
    $result = mysqli_query($conn, $sql);
    mysqli_close($conn);

    if($result && mysqli_num_rows($result) > 0){
        foreach($result as $coluna){
            $statusFormatado = ucfirst($coluna['status']);
            $classeBadge = 'badge-aberto';
            
            if(strtolower($coluna['status']) == 'aprovado') $classeBadge = 'badge-aprovado';
            if(strtolower($coluna['status']) == 'recusado' || strtolower($coluna['status']) == 'reprovado') $classeBadge = 'badge-danger';

            $html .= "<tr>
                          <td>".$coluna['idOrcamento']."</td>
                          <td>".$coluna['nomeCliente']."</td>
                          <td>".$coluna['nomeMarca']." ".$coluna['nomeModelo']."</td>
                          <td>".$coluna['peca']."</td>
                          <td>R$ ".number_format($coluna['valorUni'], 2, ',', '.')."</td>
                          <td>R$ ".number_format($coluna['maoObra'], 2, ',', '.')."</td>
                          <td><strong>R$ ".number_format($coluna['valorTotal'], 2, ',', '.')."</strong></td>
                          <td><span class='badge ".$classeBadge."'>".$statusFormatado."</span></td>
                     </tr>";
        }
    } else {
        $html .= "<tr><td colspan='8' style='text-align:center;'>Nenhum orçamento cadastrado.</td></tr>";
    }

    return $html;
}
?>