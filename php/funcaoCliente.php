<?php

//Função para preencher a grid de usuários
    function listaClientes(){
        $html = "";

    //SQL
    $sql = "SELECT idCliente, nomeCliente, cpfCliente, telefoneCliente, cepCliente, enderecoCliente, numeroCliente, complementoCliente, bairroCliente, cidadeCliente, estadoCliente  from clientes";

    //Conectar
    include("conexao.php");

    //Executar
    $result = mysqli_query($conn,$sql);

    //Encerro conexão
    mysqli_close($conn);

    //trato o retorno
    if(mysqli_num_rows($result) > 0){
        foreach($result as $coluna){

        $html .= "<tr>                         
                          <td>".$coluna['idCliente']."</td>
                          <td >".$coluna['nomeCliente']."</td>
                          <td >".$coluna['telefoneCliente']."</td>
                          <td>
                            <button class='btn-alterar-tabela btn-alterar' title='Alterar'
                            data-id='".$coluna['idCliente']."'
                            data-nome='".htmlspecialchars($coluna['nomeCliente'],ENT_QUOTES)."'
                            data-cpf='".htmlspecialchars($coluna['cpfCliente'],ENT_QUOTES)."'
                            data-telefone='".htmlspecialchars($coluna['telefoneCliente'],ENT_QUOTES)."'
                            data-cep='".htmlspecialchars($coluna['cepCliente'],ENT_QUOTES)."'
                            data-endereco='".htmlspecialchars($coluna['enderecoCliente'],ENT_QUOTES)."'
                            data-numero='".htmlspecialchars($coluna['numeroCliente'],ENT_QUOTES)."'
                            data-complemento='".htmlspecialchars($coluna['complementoCliente'],ENT_QUOTES)."'
                            data-bairro='".htmlspecialchars($coluna['bairroCliente'],ENT_QUOTES)."'
                            data-cidade='".htmlspecialchars($coluna['cidadeCliente'],ENT_QUOTES)."'
                            data-estado='".htmlspecialchars($coluna['estadoCliente'],ENT_QUOTES)."'
                            <i class='fas fa-pen'></i>
                            > Alterar
                            </button> 
                            
                            <button class='btn-apagar-tabela btn-apagar' title='Apagar'>
                            <i class='fas fa-pen'></i> Apagar
                            </button>

                          </td>

                     </tr>";
        }
    }

        return $html;
    }
    ?>

