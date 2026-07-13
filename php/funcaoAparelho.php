<?php

function listaAparelho(){
    $html = "";

    // Query unindo as tabelas de clientes, marcas e modelos cadastrados
    $sql = "SELECT a.idAparelho, a.Cliente_idCliente, mo.Marca_idMarca, a.Modelo_idModelo, a.imeiAparelho,
                   c.nomeCliente, m.nomeMarca, mo.nomeModelo
            FROM aparelho a
            LEFT JOIN clientes c ON a.Cliente_idCliente = c.idCliente
            LEFT JOIN modelo mo ON a.Modelo_idModelo = mo.idModelo
            LEFT JOIN marca m ON mo.Marca_idMarca = m.idMarca";
            
    include("includes/conexao.php");
    $result = mysqli_query($conn, $sql);
    
    if($result && mysqli_num_rows($result) > 0){
        foreach($result as $coluna){
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
                    <button class='btn-aviso btn-alterar' 
                            data-id='{$id}' 
                            data-cliente='{$idCliente}' 
                            data-marca='{$idMarca}' 
                            data-modelo='{$modelo}' 
                            data-imei='{$imei}'>
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
    mysqli_close($conn);
    return $html;
}

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
            $selected = ($id == $idSelecionado) ? "selected" : "";
            $html .= "<option value='{$id}' {$selected}>{$nome}</option>";
        }
    }
    return $html;
}

function listaOpcoesClientes($idSelecionado = null) {
    $html = "";
    // CORREÇÃO: Alterado de 'clientes' para 'cliente' conforme definido no techos.sql
    $sql = "SELECT idCliente, nomeCliente FROM clientes ORDER BY nomeCliente ASC";
    
    include("conexao.php");
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
    return $html;
}
?>