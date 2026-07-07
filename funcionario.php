<?php
include("php/funcoes.php");

$currentPage = 'funcionario';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="css/os.css">
    <link rel="stylesheet" href="css/style_cadastros.css">
    <title>Cadastro de Colaboradores</title>
</head>
<body>
   
<?php include('sidebar.php'); ?>

<div class="page-content">

<div class="os-header">
        <div>
            <h2>Gerenciamento de Colaboradores</h2>
        </div>
      </div>


<!--   TABELAS DOS CLIENTES                                                          -->

       <fieldset class="search-fieldset">
            <legend>Pesquisar Colaborador</legend>
            <div class="search-box">
                <input type="text" id="pesquisar" name="pesquisar" placeholder="ID ou Nome...">
                <button type="button" class="btn btn-blue" id="btnBuscar">Buscar</button>
                <input type="submit" class="btn btn-sucesso" value="Novo Colaborador" id="botaoAbrir" >
                </select>
            </div>
        </fieldset>
       
      
      <div class="section-card">

      <div class="table-container"> 
            <table  class="os-table">
                <thead>
                  <tr>
                    <th>Matrícula</th>
                    <th>Tipo De Acesso</th>
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
        
         <h2>Tipo de Colaborador</h2>

         <div class="linhaFormulario">
           <select name="" id="" >
              <option value="">Selecione...</option>
              <option value="">Administrador</option>
              <option value="">Atendente</option>
              <option value="">Técnico</option>
           </select>
         </div>

       <div class="botaoContainer"> <input type="submit" value="Salvar" id="botaoSalvar" ></div>

     </form>

  </div>
</div>
</div>

   <script src="js/scriptCadastro.js"></script>
</body>
</html>