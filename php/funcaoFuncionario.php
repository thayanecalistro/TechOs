<?php

//Função para preencher a grid de usuários
    function listaFuncionarios(){
        $html = "";

    //SQL
    $sql = "SELECT idFuncionario, tipoFuncionario, nomeFuncionario, telefoneFuncionario from funcionario";

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
      // Modifique a linha do link Alterar para ficar assim:

        $html .= "<tr>                         
                          <td>".$coluna['idFuncionario']."</td>
                          <td>".$coluna['tipoFuncionario']."</td>
                          <td>".$coluna['nomeFuncionario']."</td>
                          <td>".$coluna['telefoneFuncionario']."</td>
                          <td>
                            <button class='btn-alterar-tabela btn-alterar' title='Alterar'>
                            <i class='fas fa-pen'></i> Alterar
                            </button> 
                            
                            <button class='btn-apagar-tabela btn-apagar' title='Apagar'>
                            <i class='fas fa-pen'></i> Apagar
                            </button>

                            </td>
                     </tr>";
            $contador++; // Soma 1 para a próxima linha
        }
    }

        return $html;
    }
    ?>