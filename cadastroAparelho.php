<?php
session_start();

if (!isset($_SESSION['idFuncionario'])) {
    header("Location: login.php");
    exit();
}

include("php/funcoes.php");
$currentPage = 'aparelho';

// Pega o termo pesquisado via formulário/GET
$termoPesquisado = $_GET['pesquisar'] ?? null;
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style_geral.css">
    <link rel="stylesheet" href="css/aparelhos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>Cadastro de Aparelho</title>
</head>
<body>

   <?php include('sidebar.php'); ?>
    
   <div class="main-content-container">

        <div class="header-table-section">
            <h2>Gerenciamento de Aparelhos</h2>
        </div>

        <fieldset class="search-fieldset">
            <legend>Pesquisar</legend>
            <form method="GET" action="cadastroAparelho.php" class="search-box"> 
                <input type="text" id="pesquisar" name="pesquisar" placeholder="ID ou Nome..." value="<?php echo htmlspecialchars($termoPesquisado ?? ''); ?>">
                <button type="submit" class="btn btn-blue" id="btnBuscar">Buscar</button>
            </form>
        </fieldset>

        <div class="section-card">

            <div class="footer-actions">
                <button type="button" class="btn btn-sucesso" id="btnAbrirNovo">Novo</button>
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
                        <?php echo listaAparelho($termoPesquisado); ?> 
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- MODAL: CADASTRAR -->
    <div id="modalAparelho" class="modal">
        <div class="modal-conteudo">
            <span id="btnFecharNovo" class="botaoFechar">&times;</span>
            <h3>Cadastrar Novo Aparelho</h3>

            <form action="php/salvarAparelho.php?opcao=I" method="POST" class="modal-form">
                <label>Cliente:</label>
                <select name="nCliente" required>
                    <option value="">Selecione o Cliente</option>
                    <?php echo listaOpcoesClientes(); ?>
                </select>

                <label>Marca:</label>
                <select name="nMarca" required>
                    <option value="">Selecione a Marca</option>
                    <?php echo listaOpcoesMarcas(); ?>
                </select>

                <label>Modelo:</label>
                <input type="text" name="nModelo" placeholder="Digite o nome do modelo" required>

                <label>IMEI:</label>
                <input type="text" name="nImei" placeholder="Somente números" required>

                <div class="form-actions">
                    <button type="button" id="btnCancelarNovo" class="btn-novo" style="background-color: #6c757d;">Cancelar</button>
                    <button type="submit" class="btn-sucesso">Cadastrar</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL: ALTERAR -->
    <div id="modalAlterarAparelho" class="modal">
        <div class="modal-conteudo">
            <span id="btnFecharModalAlterar" class="botaoFechar">&times;</span>
            <h3>Alterar Aparelho</h3>

            <form id="formAlterar" method="POST" class="modal-form">
                <input type="hidden" name="idAparelho" id="alt_id">
                
                <label>Cliente:</label>
                <select name="nCliente" id="alt_cliente" required>
                    <option value="">Selecione o Cliente</option>
                    <?php echo listaOpcoesClientes(); ?>
                </select>

                <label>Marca:</label>
                <select name="nMarca" id="alt_marca" required>
                    <option value="">Selecione a Marca</option>
                    <?php echo listaOpcoesMarcas(); ?>
                </select>

                <label>Modelo:</label>
                <input type="text" name="nModelo" id="alt_modelo" placeholder="Digite o nome do modelo" required>

                <label>IMEI:</label>
                <input type="text" name="nImei" id="alt_imei" required>

                <div class="form-actions">
                    <button type="button" id="btnCancelarAlterar" class="btn-novo" style="background-color: #6c757d;">Cancelar</button>
                    <button type="submit" class="btn-sucesso">Salvar Alterações</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL: EXCLUIR -->
    <div id="modalExcluirAparelho" class="modal">
        <div class="modal-conteudo" style="text-align: center; width: 350px;">
            <span id="btnFecharModalExcluir" class="botaoFechar">&times;</span>
            <h3 style="border-bottom: none; margin-bottom: 10px;">Confirmar Exclusão</h3>
            <p style="margin-bottom: 25px;">Você realmente deseja excluir este aparelho?</p>

            <div class="form-actions" style="justify-content: center; gap: 15px;">
                <button type="button" id="btnNaoExcluir" class="btn-novo" style="background-color: #6c757d;">Não, Voltar</button>
                <a href="#" id="btnSimExcluir" class="btn-perigo" style="text-decoration: none; display: inline-block; padding: 6px 12px; border-radius: 3px; font-size: 14px; font-family: 'Segoe UI', sans-serif;">Sim, Excluir</a>
            </div>
        </div>
    </div>
    
    <script src="js/aparelho.js?v=4"></script>
</body>
</html>