<?php
include("php/funcoes.php");
$currentPage = 'aparelho';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/aparelho.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>Cadastro de Aparelho</title>
</head>
<body>

   <?php include('sidebar.php'); ?>
    
   <div class="main-content-container">
        <div class="header-table-section">
            <h2>Aparelhos</h2>
            <button id="btnAbrirNovo" class="btn-novo">Novo Aparelho</button>
        </div>

        <div class="table-container">
            <table class="dashboard-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Cliente</th>
                        <th>Marca</th>
                        <th>Modelo</th>
                        <th>IMEI</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                <?php echo listaAparelho(); ?> 
                </tbody>
            </table>
        </div>
    </div>

    <div id="modalAparelho" class="modal">
        <div class="modal-conteudo">
            <span id="btnFecharNovo" class="botaoFechar">&times;</span>
            <h3>Cadastrar Novo Aparelho</h3>

            <form action="php/salvarAparelho.php?opcao=I" method="POST" class="modal-form">
                
                <select name="nCliente" required>
                    <option value="">Selecione o Cliente</option>
                    <?php echo listaOpcoesClientes(); ?>
                </select>

                
                <select name="nMarca" required>
                    <option value="">Selecione a Marca</option>
                    <?php echo listaOpcoesMarcas(); ?>
                </select>

                
                <input type="text" name="nModelo" placeholder="Digite o nome do modelo" required>

                
                <input type="number" name="nImei" placeholder="Somente números" required>

                <div class="form-actions">
                    <button type="button" id="btnCancelarNovo" class="btn-perigo">Cancelar</button>
                    <button type="submit" class="btn-sucesso">Cadastrar</button>
                </div>
            </form>
        </div>
    </div>

    <div id="modalAlterarAparelho" class="modal">
        <div class="modal-conteudo">
            <span id="btnFecharModalAlterar" class="botaoFechar">&times;</span>
            <h3>Alterar Aparelho</h3>

            <form id="formAlterar" method="POST" class="modal-form">
                <input type="hidden" name="idAparelho" id="alt_id">
                
                
                <select name="nCliente" id="alt_cliente" required>
                    <option value="">Selecione o Cliente</option>
                    <?php echo listaOpcoesClientes(); ?>
                </select>

                
                <select name="nMarca" id="alt_marca" required>
                    <option value="">Selecione a Marca</option>
                    <?php echo listaOpcoesMarcas(); ?>
                </select>

                
                <input type="text" name="nModelo" id="alt_modelo" placeholder="Digite o nome do modelo" required>

                
                <input type="number" name="nImei" id="alt_imei" required>

                <div class="form-actions">
                    <button type="button" id="btnCancelarAlterar" class="btn-perigo">Fechar</button>
                    <button type="submit" class="btn-sucesso">Salvar Alterações</button>
                </div>
            </form>
        </div>
    </div>

    <script src="js/aparelho.js"></script>
</body>
</html>