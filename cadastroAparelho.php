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
    <title>Cadastro de Aparelho</title>
</head>
<body>

   <?php include('sidebar.php'); ?>
    
   <div class="main-content-container">
            <div class="header-table-section">
                <h2>Aparelhos</h2>
                <button id="btnAbrirNovo" class="btn-sucesso">Novo Aparelho</button>
            </div>

            <table class="custom-data-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Cliente</th>
                        <th>Marca</th>
                        <th>Modelo</th>
                        <th>IMEI</th>
                        <th>ações</th>
                    </tr>
                </thead>
                <tbody>
                <?php echo listaAparelho(); ?> 
                </tbody>
            </table>
        </div>

        <div id="modalAparelho" class="custom-modal-overlay">
            <div class="custom-modal-box">

                <div class="modal-header">
                    <h3>Novo Aparelho</h3>
                    <span id="btnFecharModal" class="close-icon">&times;</span>
                </div>

                <form action="php/salvarAparelho.php?opcao=I" method="POST" class="modal-form"> <!--FAZER-->
                    <input type="hidden" name="action" value="cadastrar">
                    
                    <label>Cliente:</label>
                    <input type="text" name="nomeAparelho" required>

                    <label>Marca:</label>
                    <input type="text" name="marcaAparelho" required>

                    <label>Modelo:</label>
                    <input type="text" name="modeloAparelho" required>

                    <label>IMEI:</label>
                    <input type="int" name="imeiAparelho" required>

                    <div class="form-actions">
                        <button type="button" id="btnCancelar" class="btn-perigo">Fechar</button>
                        <button type="submit" class="btn-sucesso">Salvar</button>
                    </div>
                </form>
            </div>
        </div>

        <div id="modalNovoAparelho" class="custom-modal-overlay" style="display: none;">
    <div class="custom-modal-box">
        <div class="modal-header">
            <h3>Cadastrar Novo Aparelho</h3>
            <span id="btnFecharNovo" class="close-icon">&times;</span>
        </div>

        <form action="php/salvarAparelho.php?opcao=I" method="POST" class="modal-form">
            <label>Cliente:</label>
            <select name="nCliente" required>
                <option value="">Selecione o Cliente</option>
                <option value="1">Cliente Teste</option>
            </select>

            <label>Marca:</label>
            <select name="nMarca" required>
                <option value="">Selecione a Marca</option>
                <option value="1">Apple</option>
                <option value="2">Samsung</option>
            </select>

            <label>Modelo:</label>
            <input type="text" name="nModelo" placeholder="Ex: iPhone 13" required>

            <label>IMEI:</label>
            <input type="number" name="nImei" placeholder="Somente números" required>

            <div class="form-actions">
                <button type="button" id="btnCancelarNovo" class="btn-perigo">Cancelar</button>
                <button type="submit" class="btn-sucesso">Cadastrar</button>
            </div>
        </form>
    </div>
</div>

        <div id="modalAlterarAparelho" class="custom-modal-overlay">
    <div class="custom-modal-box">
        <div class="modal-header">
            <h3>Alterar Aparelho</h3>
            <span id="btnFecharModalAlterar" class="close-icon">&times;</span>
        </div>

        <form id="formAlterar" method="POST" class="modal-form">
            <input type="hidden" name="idAparelho" id="alt_id">
            
            <label>Cliente:</label>
            <select name="nCliente" id="alt_cliente" required>
                <option value="1">Cliente Exemplo 1</option>
                <option value="2">Cliente Exemplo 2</option>
            </select>

            <label>Marca:</label>
            <select name="nMarca" id="alt_marca" required>
                <option value="1">Apple</option>
                <option value="2">Samsung</option>
            </select>

            <label>Modelo:</label>
            <input type="text" name="nModelo" id="alt_modelo" required>

            <label>IMEI:</label>
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