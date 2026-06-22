<?php
include("../includes/conexao.php");

$acao = isset($_GET['acao']) ? $_GET['acao'] : '';

// 1. Busca dinamicamente os clientes pelo nome ao digitar
if ($acao == 'clientes') {
    $busca = mysqli_real_escape_string($conn, $_GET['busca']);
    $sql = "SELECT idCliente, nomeCliente FROM cliente WHERE nomeCliente LIKE '%$busca%' LIMIT 5";
    $res = mysqli_query($conn, $sql);
    $dados = mysqli_fetch_all($res, MYSQLI_ASSOC);
    echo json_encode($dados);
}

// 2. Busca apenas os aparelhos do cliente selecionado trazendo Marca e Modelo
if ($acao == 'aparelhos') {
    $idCliente = intval($_GET['idCliente']);
    $sql = "SELECT a.idAparelho, m.nomeMarca, mo.nomeModelo 
            FROM aparelho a
            INNER JOIN marca m ON a.Marca_idMarca = m.idMarca
            INNER JOIN modelo mo ON a.Modelo_idModelo = mo.idModelo
            WHERE a.Cliente_idCliente = '$idCliente'";
    $res = mysqli_query($conn, $sql);
    $dados = mysqli_fetch_all($res, MYSQLI_ASSOC);
    echo json_encode($dados);
}

// 3 e 4. Busca peças e retorna também o valor registrado no estoque
if ($acao == 'pecas') {
    $busca = mysqli_real_escape_string($conn, $_GET['busca']);
    $sql = "SELECT peca, valor FROM estoque WHERE peca LIKE '%$busca%' LIMIT 5";
    $res = mysqli_query($conn, $sql);
    $dados = mysqli_fetch_all($res, MYSQLI_ASSOC);
    echo json_encode($dados);
}

// 7. Filtro de pesquisa pelo ID do orçamento ou nome do cliente
if ($acao == 'filtrar_orcamentos') {
    $termo = mysqli_real_escape_string($conn, $_GET['termo']);
    
    $sql = "SELECT o.idOrcamento, c.nomeCliente, m.nomeMarca, mo.nomeModelo, o.peca, o.valorUni, o.maoObra, o.valorTotal, o.status 
            FROM orcamento o
            INNER JOIN cliente c ON o.Cliente_idCliente = c.idCliente
            INNER JOIN aparelho a ON o.Aparelho_idAparelho = a.idAparelho
            INNER JOIN marca m ON a.Marca_idMarca = m.idMarca
            INNER JOIN modelo mo ON a.Modelo_idModelo = mo.idModelo
            WHERE c.nomeCliente LIKE '%$termo%' OR o.idOrcamento = '$termo'";
            
    $result = mysqli_query($conn, $sql);
    
    $html = "";
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
        $html .= "<tr><td colspan='8' style='text-align:center;'>Nenhum resultado encontrado.</td></tr>";
    }
    echo $html;
}

mysqli_close($conn);

// Adicione este bloco dentro do seu php/buscar_dados.php existente:
if ($acao == 'listar_marcas') {
    // Busca id e nome da sua tabela 'marca' enviada na imagem
    $sql = "SELECT idMarca, nomeMarca FROM marca ORDER BY nomeMarca ASC";
    $res = mysqli_query($conn, $sql);
    $dados = mysqli_fetch_all($res, MYSQLI_ASSOC);
    echo json_encode($dados);
    exit();
}
?>