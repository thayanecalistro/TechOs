<?php

//Função para preencher a grid de usuários
    function listaClientes($termoBusca = ""){
        $html = "";

   
    //Conectar
    include("includes/conexao.php");

    //SQL
    $sql = "SELECT idCliente, nomeCliente, cpfCliente, telefoneCliente, cepCliente, enderecoCliente, numeroCliente, complementoCliente, bairroCliente, cidadeCliente, estadoCliente  from clientes";

   if (!empty($termoBusca)) {

      $termoLimpo = mysqli_real_escape_string($conn, $termoBusca);
      $sql .= " WHERE idCliente LIKE '%$termoLimpo%' OR nomeCliente LIKE '%$termoLimpo%'";
    }

    $sql .= " ORDER BY idCliente DESC";

   
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
                            > Alterar
                            </button> 
                            
                            <button class='btn-apagar-tabela btn-apagar' title='Apagar' data-id='".$coluna['idCliente']."'>
                            Apagar
                            </button>
                            
                            <button
                            class='btn-visualizar-tabela btn-visualizar' title='Visualizar'

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
                            >Visualizar                           
                            </button>
                          </td>

                     </tr>";
        }
    } else {
        $html .= "<tr><td colspan='4' style='text-align:center;'>Nenhum cliente encontrado.</td></tr>";
    }

        return $html;
    }
    ?>

