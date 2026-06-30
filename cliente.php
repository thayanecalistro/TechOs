<?php

include("php/funcoes.php");
$currentPage = 'cliente';

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechOS - Cadastro de Clientes</title>

    <link rel="stylesheet" href="css/os.css"> 
    <link rel="stylesheet" href="css/style_cadastros.css"> 
</head>
<body>

    <?php include('sidebar.php'); ?>

    <div class="page-content">
        
        <div class="os-header">
            <div>
                <h2>Gerenciar Clientes</h2>
            </div>
            <button type="submit" class="btn btn-sucesso" id="botaoAbrir">+ Novo</button>
        </div>

        <fieldset class="search-fieldset">
            <legend>Pesquisar</legend>
            <div class="search-box">
                <input type="text" id="pesquisar" name="pesquisar" placeholder="ID ou Diagnóstico...">
                <button type="button" class="btn btn-blue" id="btnBuscar">Buscar</button>
                <select id="ordenarSelect" class="btn btn-cyan" style="color: #102a43; cursor: pointer; height: 31px; padding: 0 10px;">
                    <option value="" style="color: black;">Ordenar</option>
                    <option value="id" style="color: black;">ID</option>
                    <option value="status" style="color: black;">Status</option>
                </select>
            </div>
        </fieldset>

        <div class="section-card">

            <div class="table-container">
                <table class="os-table" id="orcamentoTable">
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

    <!--         MODAL PARA ALTERAÇÃO DE DADOS DO COLABORADOR -->
    <div id="meuModalAlterar" class="modal">
        <div class="modal-conteudo">
            <span class="botaoFecharAlterar">&times;</span>
            <h2>Cadastro de Clientes</h2>

            <form method="POST" action="php/salvarCliente.php?opcao=I">
            
                <input type="hidden" id="alterarId" name="nIdCliente">

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

    <script src="js/scriptCadastro.js"></script>
</body>
</html>