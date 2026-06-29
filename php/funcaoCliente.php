<head>
    <link rel="stylesheet" href="css/style_clientes.css">
</head>
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
      // Modifique a linha do link Alterar para ficar assim:

        $html .= "<tr>                         
                          <td>".$coluna['idCliente']."</td>
                          <td >".$coluna['nomeCliente']."</td>
                          <td >".$coluna['telefoneCliente']."</td>
                          <td ><a href='javascript:void(0);' onclick='abrirModalAlterar(".$coluna['idCliente'].")'>Alterar</a> 

                              <a href='alterarCliente.php?id=".$coluna['idCliente']."'>Vizu</a> | 

                              <a href='apagarCliente.php?id=".$coluna['idCliente']."'>Excluir</a></td>

                     </tr>";
            $contador++; // Soma 1 para a próxima linha
        }
    }

        return $html;
    }
    ?>