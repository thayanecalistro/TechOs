<?php
include("php/funcoes.php");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style_cadastros.css">
    <title>Cadastro de Colaboradores</title>
</head>
<body>
   
<?php include('sidebar.php'); ?>

<div class="conteudo-principal">

<!--                   TELA DE CADASTRO                                 -->
<div id="meuModal" class="modal">
  <div class="modal-conteudo">
   <span class="botaoFechar">&times;</span>
    <h2>Cadastro de Colaboradores</h2>

     <form method="POST" action="php/salvarColaborador.php?opcao=I">

       <div class="linhaFormulario">
         <input type="text" placeholder="Nome do Colaborador" name="nNome">

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
            <legend>Pesquisar Colaborador</legend>
            <div class="search-box">
                <label for="pesquisar">Pesquisar:</label>
                <input type="text">
                </select>
            </div>
        </fieldset>

        <div class="botaoContainer">
        <input type="submit" value="Novo Colaborador" id="botaoAbrir" >
       </div> 
       
      <br>
      <div calss="tela-fundo">
        <h3>Colaboradores</h3>
      <div class="table-container"> 
            <table  border= "1" class="tabelas" >
                <thead>
                  <tr>
                    <th>Matrícula</th>
                    <th>Nome do Colaborador</th>
                    <th>Contato</th>
                    <th>Ações</th>
                  </tr>
                  <?php echo listaFuncionarios(); ?>
                </thead>
            </table>
      </div>
      </div>
</div>
   <script src="js/scriptColaborador.js"></script>
</body>
</html>