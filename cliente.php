<?php
include("php/funcoes.php");

$currentPage = 'cliente';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="css/os.css">
    <link rel="stylesheet" href="css/style_cadastros.css">
    <title>Cadastro de Clientes</title>
</head>
<body>
  
    <?php include('sidebar.php'); ?>

    <div class="page-content">

      <div class="os-header">
        <div>
            <h2>Gerenciamento de Clientes</h2>
        </div>
      </div>

      <!--   TABELAS DOS CLIENTES                                                          -->  
      <fieldset class="search-fieldset">
          <legend>Pesquisar</legend>
          <div class="search-box"> 
              <input type="text" id="pesquisar" name="pesquisar" placeholder="ID ou Nome...">
              <button type="button" class="btn btn-blue" id="btnBuscar">Buscar</button>
              </select>
          </div>
      </fieldset>

      <div class="section-card"> 

      <button type="button" class="btn btn-sucesso" id="botaoAbrir">Novo Cliente</button>
      
        <div class="table-container"> 
            <table  class="os-table" >
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Nome do Cliente</th>
                    <th>Contato</th>
                    <th>Ações</th>
                  </tr>
                </thead>
                <tbody>
                  <?php echo listaClientes(); ?>
                </tbody>
            </table>
        </div>
      </div>
    </div>

    <!--                   TELA DE CADASTRO                                 -->
      <div id="meuModal" class="modal">
        <div class="modal-conteudo">
        <span class="botaoFechar">&times;</span>
          <h2>Cadastro de Clientes</h2>

          <form method="POST" action="php/salvarCliente.php?opcao=I">

            <div class="linhaFormulario">
              <input type="text" placeholder="Nome do cliente" name="nNome">
              <input type="text" placeholder="CPF" name="nCpf" >
            </div>

            <div class="linhaFormulario">
              <input type="text" placeholder="Telefone" name="nTelefone">
            </div>

              <h3>Endereço</h3>

            <div class="linhaFormulario">
              <input type="text" placeholder="CEP" name="nCep" id="cep">
              <input type="text" placeholder="Endereço" name="nEndereco" id="endereco">
            </div>

            <div class="linhaFormulario">
              <input type="text" placeholder="Número" name="nNumero" id="numero">
              <input type="text" placeholder="Complemento" name="nComplemento" id="complemento">
            </div>

            <div class="linhaFormulario">
            <input type="text" placeholder="Bairro" name="nBairro" id="bairro">
              <input type="text" placeholder="Cidade" name="nCidade" id="cidade">
            </div>

            <div class="linhaFormulario">
              <input type="text" placeholder="Estado" name="nEstado" id="estado">                     
            </div>

            <div class="botaoContainer"> <input type="submit" value="Salvar" id="botaoSalvar" ></div>

          </form>

        </div>
      </div>

<!--         MODAL PARA ALTERAÇÃO DE DADOS DO COLABORADOR -->
<div id="meuModalAlterar" class="modal">
  <div class="modal-conteudo">
   <span class="botaoFecharAlterar">&times;</span>
    <h2>Cadastro de Clientes</h2>

     <form method="POST" action="php/salvarCliente.php?opcao=U">
      
     <input type="hidden" id="alterarId" name="nIdCliente">

      <div class="linhaFormulario">
        <div class="grupo-input">
           <label for="">Nome</label>
           <input type="text" name="nNome">
        </div>
        <div class="grupo-input">
           <label for="">CPF</label>
           <input type="text" name="nCpf">
        </div>
      </div>

       <div class="linhaFormulario">

         <div class="grupo-input">
           <label for="">Telefone</label>
           <input type="text" name="nTelefone">
         </div>

       </div>

         <h3>Endereço</h3>

       <div class="linhaFormulario">

         <div class="grupo-input">
           <label for="">Cep</label>
           <input type="text" name="nCep" id="alterarCep">
         </div>

         <div class="grupo-input">
           <label for="">Endereco</label>
           <input type="text" name="nEndereco" id="AlterarEndereco">
         </div>
       </div>

       <div class="linhaFormulario">

         <div class="grupo-input">
           <label for="">Número</label>
           <input type="text" name="nNumero" id="alterarNumero">
         </div>

         <div class="grupo-input">
           <label for="">Complemento</label>
           <input type="text" name="nComplemento" id="alterarComplemento">
         </div>
       </div>

       <div class="linhaFormulario">

          <div class="grupo-input">
            <label for="">Bairro</label>
            <input type="text" name="nBairro" id="alterarBairro">
          </div>

          <div class="grupo-input">
            <label for="">Cidade</label>
            <input type="text" name="nCidade" id="alterarCidade">
          </div>
       </div>

       <div class="linhaFormulario">

        <div class="grupo-input">
          <label for="">Estado</label>
           <input type="text" name="nEstado" id="alterarEstado">
        </div>

       </div>

       <div class="botaoContainer"> <input type="submit" value="Salvar" id="botaoSalvar" ></div>

     </form>

  </div>
</div>

<!--   TABELAS DOS CLIENTES                                                          -->

   <script src="js/scriptCliente.js"></script>
</body>
</html>