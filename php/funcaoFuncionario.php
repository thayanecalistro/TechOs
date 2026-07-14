<?php

//Função para preencher a grid de usuários
    function listaFuncionarios(){
        $html = "";

    //SQL
    $sql = "SELECT idFuncionario, tipoFuncionario, nomeFuncionario, cpfFuncionario, emailFuncionario, telefoneFuncionario, cepFuncionario, enderecoFuncionario, numeroFuncionario, complementoFuncionario, bairroFuncionario, cidadeFuncionario, estadoFuncionario, login, senha from funcionario";

    //Conectar
    include("includes/conexao.php");

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
                          <td>
                            <button class='btn-alterar-tabela btn-alterar' title='Alterar'

                            data-id='".$coluna['idFuncionario']."'
                            data-tipo='".htmlspecialchars($coluna['tipoFuncionario'], ENT_QUOTES)."'
                            dta-nome='".htmlspecialchars($coluna['nomeFuncionario'], ENT_QUOTES)."'
                            data-cpf='".htmlspecialchars($coluna['cpfFuncionario'], ENT_QUOTES)."'
                            data-email='".htmlspecialchars($coluna['emailFuncionario'], ENT_QUOTES)."'
                            data-telefone='".htmlspecialchars($coluna['telefoneFuncionario'], ENT_QUOTES)."'
                            data-cep='".htmlspecialchars($coluna['cepFuncionario'], ENT_QUOTES)."'
                            data-endereco='".htmlspecialchars($coluna['enderecoFuncionario'], ENT_QUOTES)."'
                            data-numero='".htmlspecialchars($coluna['numeroFuncionario'], ENT_QUOTES)."'
                            data-complemento='".htmlspecialchars($coluna['complementoFuncionario'], ENT_QUOTES)."'
                            data-bairro='".htmlspecialchars($coluna['bairroFuncionario'], ENT_QUOTES)."'
                            data-cidade='".htmlspecialchars($coluna['cidadeFuncionario'], ENT_QUOTES)."'
                            data-estado='".htmlspecialchars($coluna['estadoFuncionario'], ENT_QUOTES)."'
                            data-login='".htmlspecialchars($coluna['login'], ENT_QUOTES)."'
                            data-senha='".htmlspecialchars($coluna['senha'], ENT_QUOTES)."'

                            >
                            Alterar
                            </button> 
                            
                            <button class='btn-apagar-tabela btn-apagar' title='Apagar'
                            data-id='".$coluna['idFuncionario']."'
                            >
                            Apagar
                            </button>

                            </td>
                     </tr>";
            $contador++; // Soma 1 para a próxima linha
        }
    }

        return $html;
    }
    ?>