<?php
//Função para preencher a grid de usuários--------------------------------------------------------------------
function listaAparelho(){
    $html = "";

    //SQL
    $sql = "SELECT * FROM aparelho";
    include("conexao.php");
    
     $result = mysqli_query($conn, $sql);
  
     mysqli_close($conn);
    
     if(mysqli_num_rows($result) > 0){
     $contador = 1;
      foreach($result as $coluna){
          $id = $coluna['idAparelho'];
          $cliente = $coluna['Cliente_idCliente'];
          $marca = $coluna['Marca_idMarca'];
          $modelo = $coluna['Modelo_idModelo'];
          $imei = $coluna['imeiAparelho'];
  
          $html .= "<tr>
              <td>{$id}</td>
              <td>{$cliente}</td>
              <td>{$marca}</td>
              <td>{$modelo}</td>
              <td>{$imei}</td>
              <td>
                  <button class='btn-sucesso btn-alterar' style='background-color: #ffc107; color: #000;' 
                          data-id='{$id}' 
                          data-cliente='{$cliente}' 
                          data-marca='{$marca}' 
                          data-modelo='{$modelo}' 
                          data-imei='{$imei}'>Alterar</button>
                          
                  <button class='btn-perigo btn-excluir' data-id='{$id}'>Excluir</button>
              </td>
          </tr>";
         $contador++;
      }
  }
    return $html;
   }
?>