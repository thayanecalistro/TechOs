<?php
function listarOrcamentos(){
    $html = "";

    // INNER JOIN robusto associando as chaves estrangeiras reais das suas tabelas
    $sql = "SELECT o.idOrcamento, c.nomeCliente, m.nomeMarca, mo.nomeModelo, 
                   o.peca, o.valorUni, o.maoObra, o.valorTotal, o.status 
            FROM orcamento o
            INNER JOIN clientes c ON o.Cliente_idCliente = c.idCliente
            INNER JOIN aparelho a ON o.Aparelho_idAparelho = a.idAparelho
            INNER JOIN modelo mo ON a.Modelo_idModelo = mo.idModelo
            INNER JOIN marca m ON mo.Marca_idMarca = m.idMarca";

    include("includes/conexao.php");
    $result = mysqli_query($conn, $sql);

    if(!$result){
        die("Erro na consulta ao banco de dados". mysqli_error($conn));
    }

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

    mysqli_close($conn);
    return $html;
}

function comboClientes() {
    $html = ""; 
    $sql = "SELECT idCliente, nomeCliente FROM clientes ORDER BY nomeCliente ASC";
    
    // ATENÇÃO: Verifique se o caminho da conexão está correto. 
    // Se o arquivo de funções está na pasta "php/", o caminho correto geralmente é "conexao.php" 
    // ou "../includes/conexao.php". Ajuste conforme a estrutura das suas pastas.
    include("conexao.php"); 

    if (!$conn) {
        return "<option value='Erro de Conexão'></option>";
    }

    $result = mysqli_query($conn, $sql);

    // Se a query der erro, isso vai te ajudar a descobrir o motivo técnico:
    if (!$result) {
        return "<option value='Erro no SQL: " . mysqli_error($conn) . "'></option>";
    }

    if (mysqli_num_rows($result) > 0) {
        while ($coluna = mysqli_fetch_assoc($result)) {
            $html .= "<option value='" . htmlspecialchars($coluna['nomeCliente'], ENT_QUOTES, 'UTF-8') . "' data-id='" . $coluna['idCliente'] . "'></option>";
        }
    }
    
    mysqli_close($conn);
    return $html;
}

?>