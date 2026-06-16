<?php
include("php/funcoes.php")
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Cadastro de Clientes</title>
</head>
<body>
    <h1> Cadastro de Clientes</h1>

   <h3>Clientes</h3>
   <div class="botaoContainer">
    <button id="botaoAbrir">Novo Cliente</button> 
  </div>

<div id="meuModal" class="modal">
  <div class="modal-conteudo">
   <span class="botaoFechar">&times;</span>
    <h2>Cadastro de Clientes</h2>

     <form method="POST" action="php/salvarCliente.php?opcao=I">

       <div class="linhaFormulario">
         <input type="text" placeholder="Nome do cliente" name="nNome">

         <input type="text" placeholder="CPF" name="nCpf">
       </div>

       <div class="linhaFormulario">
         <input type="text" placeholder="Telefone" name="nTelefone">
       </div>

         <h3>Endereço</h3>

       <div class="linhaFormulario">
         <input type="text" placeholder="CEP" name="nCep">
         <input type="text" placeholder="Endereço" name="nEndereco">
       </div>

       <div class="linhaFormulario">
         <input type="text" placeholder="Número" name="nNumero">
         <input type="text" placeholder="Complemento" name="nComplemento">
       </div>

       <div class="linhaFormulario">
       <input type="text" placeholder="Bairro" name="nBairro">
         <input type="text" placeholder="Cidade" name="nCidade">
       </div>

       <div class="linhaFormulario">
         <input type="text" placeholder="Estado" name="nEstado">                     
       </div>

       <div class="botaoContainer"> <input type="submit" value="Salvar" id="botaoSalvar" ></div>

     </form>

  </div>
</div>

   <table class="tabelas">
      <tr>
        <th>ID</th>
        <td>Nome do Cliente</td>
        <td>Contato</td>
        <td>Ações</td>
      </tr>
      <?php echo listaClientes(); ?>
   </table>
   
    
   <script src="js/script.js"></script>
</body>
</html>