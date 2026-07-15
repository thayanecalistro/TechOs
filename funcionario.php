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
                </select>
            </div>
        </fieldset>
       
      
      <div class="section-card">

       <input type="submit" class="btn btn-sucesso" value="Novo Colaborador" id="botaoAbrir" >

      <div class="table-container"> 
            <table  class="os-table">
                <thead>
                  <tr>
                    <th>Matrícula</th>
                    <th>Tipo De Acesso</th>
                    <th>Nome do Colaborador</th>
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

     <form method="POST" action="php/salvarFuncionario.php?opcao=I">

       <div class="linhaFormulario">
         <input type="text" placeholder="Nome do Colaborador" name="nNome">
         <input type="text" placeholder="CPF" name="nCpf">
       </div>

       <div class="linhaFormulario">
         <input type="text" placeholder="Telefone" name="nTelefone">
         <input type="text" placeholder="E-mail" name="nEmail">
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
        
         <h2>Tipo de Colaborador</h2>

         <div class="linhaFormulario">
        
           <div class="grupo-input">
             <select name="nTipo" id="tipo" >
                <option value="">Selecione...</option>
                <option value="Administrador">Administrador</option>
                <option value="Atendente">Atendente</option>
                <option value="Técnico">Técnico</option>
             </select>
           </div>

         </div>
        
         <h2>Acesso do colaborador</h2>

         <div class="linhaFormulario">
           <input type="text" placeholder="Login" name="nLogin">
           <input type="text" placeholder="Senha" name="nSenha">
         </div>
       <div class="botaoContainer"> <input type="submit" value="Salvar" id="botaoSalvar" ></div>

     </form>

  </div>
</div>


<!--         MODAL PARA ALTERAÇÃO DE DADOS DO COLABORADOR -->
<div id="meuModalAlterar" class="modal">
  <div class="modal-conteudo">
   <span class="botaoFecharAlterar">&times;</span>
    <h2>Cadastro de Colaboradores</h2>

     <form method="POST" action="php/salvarFuncionario.php?opcao=U">
       
     <input type="hidden" name="idFuncionario" id="alterarId">

     <div class="linhaFormulario">
          <div class="grupo-input">
            <label for="">Nome</label>
            <input type="text" name="nNome" id="alterarNome">
          </div>
          <div class="grupo-input">
            <label for="">CPF</label>
            <input type="text" name="nCpf" id="alterarCpf">
          </div>
        </div>

        <div class="linhaFormulario">
        <div class="grupo-input">
            <label for="">E-mail</label>
            <input type="text" name="nEmail" id="alterarEmail">
          </div>
          <div class="grupo-input">
            <label for="">Telefone</label>
            <input type="text" name="nTelefone" id="alterarTelefone">
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
            <input type="text" name="nEndereco" id="alterarEndereco">
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
        
         <h2>Tipo de Colaborador</h2>

         <div class="linhaFormulario">
        
           <div class="grupo-input">
             <select name="nTipo" id="alterarTipo" >
                <option value="">Selecione...</option>
                <option value="Administrador">Administrador</option>
                <option value="Atendente">Atendente</option>
                <option value="Técnico">Técnico</option>
             </select>
           </div>

         </div>
        
         <h2>Acesso do colaborador</h2>

         <div class="linhaFormulario">
           <div class="grupo-input">
             <label for="">login</label>
             <input type="text" placeholder="Login" name="nLogin" id="alterarLogin">
           </div>

           <div class="grupo-input">
             <label for="">Senha</label>
             <input type="text" placeholder="Senha" name="nSenha" id="alterarSenha">
           </div>
         </div>
       <div class="botaoContainer"> <input type="submit" value="Salvar" id="botaoSalvar" ></div>

     </form>

  </div>
</div>

   <script src="js/scriptFuncionario.js"></script>
</body>
</html>