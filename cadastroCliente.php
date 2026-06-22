<?php
include("php/funcoes.php");

$currentPage = 'cliente';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style_clientes.css">
    <title>Cadastro de Clientes</title>
</head>
<body>
   
<?php include('sidebar.php'); ?>

<div class="conteudo-principal">
<!--<div style="flex: ; width: 100%;" >-->
<!--                   TELA DE CADASTRO                                 -->
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
</div>

<!--   TABELAS DOS CLIENTES                                                          -->
<div class="table-section">        

       <fieldset class="search-container">
            <legend>Pesquisar Cliente</legend>
            <div class="search-box">
                <label for="pesquisar">Pesquisar:</label>
                <input type="text" id="pesquisar" class="form-control search-input" name="pesquisar" placeholder="ID ou Nome do Cliente...">
                <button type="button" class="btn btn-blue search-btn" id="btnBuscar">Buscar</button>
                <select id="ordenarSelect" class="btn btn-cyan" style="color: #102a43; cursor: pointer; height: 31px; padding: 0 10px;">
                    <option value="" style="color: black;">Ordenar</option>
                    <option value="id" style="color: black;">ID</option>
                    <option value="nome" style="color: black;">Nome (Cliente)</option>
                </select>
            </div>
        </fieldset>

        <div class="botaoContainer">
        <input type="submit" value="Novo Cliente" id="botaoAbrir" >
       </div> 
       
      <br>
      <div calss="tela-fundo">
        <h3>Clientes</h3>
      <div class="table-container"> 
            <table  border= "1" class="tabelas" >
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Nome do Cliente</th>
                    <th>Contato</th>
                    <th>Ações</th>
                  </tr>
                  <?php echo listaClientes(); ?>
                </thead>
            </table>
      </div>
      </div>
</div>
   <script src="js/scriptCliente.js"></script>
</body>
</html>