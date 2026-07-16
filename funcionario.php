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
         <input type="text" placeholder="Nome do Colaborador" name="nNome" required>
         <input type="text" placeholder="CPF" name="nCpf" required>
       </div>

       <div class="linhaFormulario">
         <input type="text" placeholder="Telefone" name="nTelefone" required>
         <input type="text" placeholder="E-mail" name="nEmail" required>
       </div>

         <h3>Endereço</h3>

       <div class="linhaFormulario">
         <input type="text" placeholder="CEP" name="nCep" id="cep" required>
         <input type="text" placeholder="Endereço" name="nEndereco" id="endereco" required>
       </div>

       <div class="linhaFormulario">
         <input type="text" placeholder="Número" name="nNumero" id="numero" required>
         <input type="text" placeholder="Complemento (opcional)" name="nComplemento" id="complemento">
       </div>

       <div class="linhaFormulario">
       <input type="text" placeholder="Bairro" name="nBairro" id="bairro" required>
         <input type="text" placeholder="Cidade" name="nCidade" id="cidade" required>
       </div>

       <div class="linhaFormulario">
         <input type="text" placeholder="Estado" name="nEstado" id="estado" required>                     
       </div>
        
         <h2>Tipo de Colaborador</h2>

         <div class="linhaFormulario">
        
           <div class="grupo-input">
             <select name="nTipo" id="tipo" required>
                <option value="">Selecione...</option>
                <option value="Administrador">Administrador</option>
                <option value="Atendente">Atendente</option>
                <option value="Técnico">Técnico</option>
             </select>
           </div>

         </div>
        
         <h2>Acesso do colaborador</h2>

         <div class="linhaFormulario">
           <input type="text" placeholder="Login" name="nLogin" required>
           <input type="text" placeholder="Senha" name="nSenha" required>
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
            <input type="text" name="nNome" id="alterarNome" required>
          </div>
          <div class="grupo-input">
            <label for="">CPF</label>
            <input type="text" name="nCpf" id="alterarCpf" required>
          </div>
        </div>

        <div class="linhaFormulario">
        <div class="grupo-input">
            <label for="">E-mail</label>
            <input type="text" name="nEmail" id="alterarEmail" required>
          </div>
          <div class="grupo-input">
            <label for="">Telefone</label>
            <input type="text" name="nTelefone" id="alterarTelefone" required>
          </div>
        </div>

         <h3>Endereço</h3>

        <div class="linhaFormulario">
          <div class="grupo-input">
            <label for="">Cep</label>
            <input type="text" name="nCep" id="alterarCep" required>
          </div>

          <div class="grupo-input">
            <label for="">Endereco</label>
            <input type="text" name="nEndereco" id="alterarEndereco" required>
          </div>
        </div>

        <div class="linhaFormulario">

          <div class="grupo-input">
            <label for="">Número</label>
            <input type="text" name="nNumero" id="alterarNumero" required>
          </div>

          <div class="grupo-input">
            <label for="">Complemento</label>
            <input type="text" name="nComplemento" id="alterarComplemento">
          </div>
        </div>

        <div class="linhaFormulario">

          <div class="grupo-input">
            <label for="">Bairro</label>
            <input type="text" name="nBairro" id="alterarBairro" required>
          </div>

          <div class="grupo-input">
            <label for="">Cidade</label>
            <input type="text" name="nCidade" id="alterarCidade" required>
          </div>
        </div>

        <div class="linhaFormulario">

          <div class="grupo-input">
            <label for="">Estado</label>
            <input type="text" name="nEstado" id="alterarEstado" required>
          </div>

        </div>
        
         <h2>Tipo de Colaborador</h2>

         <div class="linhaFormulario">
        
           <div class="grupo-input">
             <select name="nTipo" id="alterarTipo" required>
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
             <input type="text" placeholder="Login" name="nLogin" id="alterarLogin" required>
           </div>

           <div class="grupo-input">
             <label for="">Senha</label>
             <input type="text" placeholder="Senha" name="nSenha" id="alterarSenha" required>
           </div>
         </div>
       <div class="botaoContainer"> <input type="submit" value="Salvar" id="botaoSalvar" ></div>

     </form>

  </div>
</div>


<!--         MODAL PARA VISUALIZAÇÃO DE DADOS PARA O COLABORADOR -->
<div id="meuModalVisualizar" class="modal">
  <div class="modal-conteudo">
   <span class="botaoFecharVisualizar">&times;</span>

    <h2>Dados do Colaborador</h2>

      <div class="linhaFormulario">
          <div class="grupo-input">
            <label for=""><strong>Matrícula: </strong></label>
            <span id="txtMatricula"></span>          
          </div>
          <div class="grupo-input">
            <label for=""><strong>Tipo de acesso: </strong></label>
            <span id="txtTipo"></span>
          </div>
      </div>
       
     <div class="linhaFormulario">
          <div class="grupo-input">
            <label for=""><strong>Nome: </strong></label>
            <span id="txtNome"></span>
          </div>
          <div class="grupo-input">
            <label for=""><strong>CPF: </strong></label>
            <span id="txtCpf"></span>
          </div>
        </div>

        <div class="linhaFormulario">
        <div class="grupo-input">
            <label for=""><strong>E-mail: </strong></label>
            <span id="txtEmail"></span>
          </div>
          <div class="grupo-input">
            <label for=""><strong>Telefone: </strong></label>
            <span id="txtTelefone"></span>
          </div>
        </div>

        <div class="linhaFormulario">
          <div class="grupo-input">
            <label for=""><strong>CEP: </strong></label>
            <span id="txtCep"></span>
          </div>
          <div class="grupo-input">
            <label for=""><strong>Endereço: </strong></label>
            <span id="txtEndereco"></span>
          </div>
        </div>

        <div class="linhaFormulario">
          <div class="grupo-input">
            <label for=""><strong>Número: </strong></label>
            <span id="txtNumero"></span>
          </div>
          <div class="grupo-input">
            <label for=""><strong>Complemento: </strong></label>
            <span id="txtComplemento"></span>
          </div>
        </div>

        <div class="linhaFormulario">
          <div class="grupo-input">
            <label for=""><strong>Bairro: </strong></label>
            <span id="txtBairro"></span>
          </div>
          <div class="grupo-input">
            <label for=""><strong>Cidade: </strong></label>
            <span id="txtCidade"></span>
          </div>
        </div>

        <div class="linhaFormulario">
          <div class="grupo-input">
            <label for=""><strong>Estado: </strong></label>
            <span id="txtEstado"></span>
          </div>
        </div>
        
         <div class="linhaFormulario">
           <div class="grupo-input">
             <label for=""><strong>Login: </strong></label>
             <span id="txtLogin"></span>
           </div>
         </div>

     </form>

  </div>
</div>

   <script src="js/scriptFuncionario.js"></script>
</body>
</html>