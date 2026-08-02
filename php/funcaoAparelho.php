<?php

function listaAparelho($pesquisa = null){
    $html = "";

    $conn = function_exists('obterConexao') ? obterConexao() : null;
    if (!$conn) {
        if (file_exists("includes/conexao.php")) include("includes/conexao.php");
        elseif (file_exists("../includes/conexao.php")) include("../includes/conexao.php");
    }

    $sql = "SELECT a.idAparelho, a.Cliente_idCliente, mo.Marca_idMarca, a.Modelo_idModelo, a.imeiAparelho,
                   c.nomeCliente, m.nomeMarca, mo.nomeModelo
            FROM aparelho a
            LEFT JOIN clientes c ON a.Cliente_idCliente = c.idCliente
            LEFT JOIN modelo mo ON a.Modelo_idModelo = mo.idModelo
            LEFT JOIN marca m ON mo.Marca_idMarca = m.idMarca";
            
    // Se houver parâmetro de busca, filtra por ID do aparelho ou Nome do Cliente
    if (!empty($pesquisa) && isset($conn)) {
        $pesquisaClean = mysqli_real_escape_string($conn, trim($pesquisa));
        $sql .= " WHERE a.idAparelho = '$pesquisaClean' OR c.nomeCliente LIKE '%$pesquisaClean%'";
    }

    $sql .= " ORDER BY a.idAparelho DESC";

    if (isset($conn)) {
        $result = mysqli_query($conn, $sql);
        
        if ($result && mysqli_num_rows($result) > 0) {
            foreach ($result as $coluna) {
                $id = $coluna['idAparelho'];
                $idCliente = $coluna['Cliente_idCliente'] ?? 0;
                $idMarca = $coluna['Marca_idMarca'] ?? 0;
                
                $nomeCliente = $coluna['nomeCliente'] ?? 'Cliente Deletado';
                $nomeMarca = $coluna['nomeMarca'] ?? 'Marca Não Associada';
                $modelo = $coluna['nomeModelo'] ?? 'Não informado';
                $imei = $coluna['imeiAparelho'];

                $html .= "<tr>
                    <td>{$id}</td>
                    <td>{$nomeCliente}</td>
                    <td>{$nomeMarca}</td>
                    <td>{$modelo}</td>
                    <td>{$imei}</td>
                    <td>
                        <button type='button' class='btn-aviso btn-alterar' 
                                data-id='{$id}' 
                                data-cliente='{$idCliente}' 
                                data-marca='{$idMarca}' 
                                data-modelo='{$modelo}' 
                                data-imei='{$imei}'>
                                Alterar
                        </button>
                                
                        <button type='button' class='btn-perigo btn-excluir' 
                                data-id='{$id}' title='Excluir'>
                                Excluir
                        </button>
                    </td>
                </tr>";
            }
        }
        mysqli_close($conn);
    }

    return $html;
}

function listaOpcoesMarcas($idSelecionado = null) {
    $html = "";
    $sql = "SELECT idMarca, nomeMarca FROM marca ORDER BY nomeMarca ASC";
    
    $conn = function_exists('obterConexao') ? obterConexao() : null;
    if (!$conn && file_exists("includes/conexao.php")) include("includes/conexao.php");
    
    if (isset($conn)) {
        $result = mysqli_query($conn, $sql);
        mysqli_close($conn);

        if ($result && mysqli_num_rows($result) > 0) {
            foreach ($result as $coluna) {
                $id = $coluna['idMarca'];
                $nome = $coluna['nomeMarca'];
                $selected = ($id == $idSelecionado) ? "selected" : "";
                $html .= "<option value='{$id}' {$selected}>{$nome}</option>";
            }
        }
    }
    return $html;
}

function listaOpcoesClientes($idSelecionado = null) {
    $html = "";
    $sql = "SELECT idCliente, nomeCliente FROM clientes ORDER BY nomeCliente ASC";
    
    $conn = function_exists('obterConexao') ? obterConexao() : null;
    if (!$conn && file_exists("includes/conexao.php")) include("includes/conexao.php");
    
    if (isset($conn)) {
        $result = mysqli_query($conn, $sql);
        mysqli_close($conn);

        if ($result && mysqli_num_rows($result) > 0) {
            foreach ($result as $coluna) {
                $id = $coluna['idCliente'];
                $nome = $coluna['nomeCliente'];
                $selected = ($id == $idSelecionado) ? "selected" : "";
                $html .= "<option value='{$id}' {$selected}>{$nome}</option>";
            }
        }
    }
    return $html;
}
?>