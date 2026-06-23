<?php

function listaAparelho(){
    $html = "";

    $sql = "SELECT a.idAparelho, a.Cliente_idCliente, a.Marca_idMarca, a.Modelo_idModelo, a.imeiAparelho,
                   c.nomeCliente, m.nomeMarca, mo.nomeModelo
            FROM aparelho a
            LEFT JOIN clientes c ON a.Cliente_idCliente = c.idCliente
            LEFT JOIN marca m ON a.Marca_idMarca = m.idMarca
            LEFT JOIN modelo mo ON a.Modelo_idModelo = mo.idModelo";
            
    include("conexao.php");
    $result = mysqli_query($conn, $sql);
    mysqli_close($conn);
    
    if($result && mysqli_num_rows($result) > 0){
        foreach($result as $coluna){
            $id = $coluna['idAparelho'];
            $idCliente = $coluna['Cliente_idCliente'];
            $idMarca = $coluna['Marca_idMarca'];
            
            $nomeCliente = $coluna['nomeCliente'] ?? 'Cliente Deletado';
            $nomeMarca = $coluna['nomeMarca'] ?? 'Marca Deletada';
            $nomeModelo = $coluna['nomeModelo'] ?? 'Modelo Deletado';
            $imei = $coluna['imeiAparelho'];
    
            $html .= "<tr>
                <td>{$id}</td>
                <td>{$nomeCliente}</td>
                <td>{$nomeMarca}</td>
                <td>{$nomeModelo}</td>
                <td>{$imei}</td>
                <td>
                    <button class='btn-alterar-tabela btn-alterar' 
                            data-id='{$id}' 
                            data-cliente='{$idCliente}' 
                            data-marca='{$idMarca}' 
                            data-modelo='{$nomeModelo}' 
                            data-imei='{$imei}' title='Alterar'>
                        <i class='fas fa-pen'></i> Alterar
                    </button>
                            
                    <button class='btn-perigo btn-excluir' 
                            data-id='{$id}' title='Excluir'>
                        <i class='fas fa-trash'></i> Excluir
                    </button>
                </td>
            </tr>";
        }
    }
    return $html;
}

// Função para buscar e listar as MARCAS do banco de dados
function listaOpcoesMarcas($idSelecionado = null) {
    $html = "";
    $sql = "SELECT idMarca, nomeMarca FROM marca ORDER BY nomeMarca ASC";
    
    include("conexao.php");
    $result = mysqli_query($conn, $sql);
    mysqli_close($conn);

    if ($result && mysqli_num_rows($result) > 0) {
        foreach ($result as $coluna) {
            $id = $coluna['idMarca'];
            $nome = $coluna['nomeMarca'];
            
            $html .= "<option value='{$id}'>{$nome}</option>";
        }
    }
    return $html;
}

// Função para buscar e listar os CLIENTES do banco de dados
function listaOpcoesClientes($idSelecionado = null) {
    $html = "";
    $sql = "SELECT idCliente, nomeCliente FROM clientes ORDER BY nomeCliente ASC";
    
    include("conexao.php");
    $result = mysqli_query($conn, $sql);
    mysqli_close($conn);

    if ($result && mysqli_num_rows($result) > 0) {
        foreach ($result as $coluna) {
            $id = $coluna['idCliente'];
            $nome = $coluna['nomeCliente'];
            
            $html .= "<option value='{$id}'>{$nome}</option>";
        }
    }
    return $html;
}

?>