<?php
//Função para preencher a grid de usuários
    function listaClientes(){
        $html = "";

    //SQL
    $sql = "SELECT idCliente, nomeCliente, telefoneCliente from clientes";

    //Conectar
    include("conexao.php");

    //Executar
    $result = mysqli_query($conn,$sql);

    //Encerro conexão
    mysqli_close($conn);

    //trato o retorno
    if(mysqli_num_rows($result) > 0){
        $contador = 1; // Criamos um contador começando em 1
        foreach($result as $coluna){

            $html .= "<tr>                         
                          <td>".$coluna['idCliente']."</td>
                          <td>".$coluna['nomeCliente']."</td>
                          <td>".$coluna['telefoneCliente']."</td>
                          <td><a href='visualizarCliente.php?id=".$coluna['idCliente']."'>Visualizar</a> |

                              <a href='alterarCliente.php?id=".$coluna['idCliente']."'>Alterar</a> | 

                              <a href='apagarCliente.php?id=".$coluna['idCliente']."'>Excluir</a></td>

                     </tr>";
            $contador++; // Soma 1 para a próxima linha
        }
    }

        return $html;
    }
    ?>