<?php

include("php/funcoes.php");
$currentPage = 'os';

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechOS - Menu</title>
    
    <link rel="stylesheet" href="css/style_geral.css">

</head>
<body>

    <!-- Inclui o menu lateral estruturado -->
    <?php include('sidebar.php'); ?>

    <div class="page-content">
        
        <div class="os-header">
            <h2>Controle de OS</h2>
        </div>


        <fieldset class="search-fieldset">
            <legend>Pesquisar</legend>
            <div class="search-box">
                <input type="text" id="pesquisar" name="pesquisar" placeholder="ID ou Nome do Cliente...">
                <button type="button" class="btn btn-blue" id="btnBuscar">Buscar</button>
                <select id="ordenarSelect" class="btn btn-cyan" style="color: #102a43; cursor: pointer; height: 31px; padding: 0 10px;">
                    <option value="" style="color: black;">Ordenar</option>
                    <option value="id" style="color: black;">ID</option>
                    <option value="nome" style="color: black;">Nome (Cliente)</option>
                </select>
            </div>
        </fieldset>

        

        <div class="section-card">
            <div class="footer-actions">
                <button type="button" class="btn btn-red" id="btnExcluir">Excluir</button>
                <button type="button" class="btn btn-light-blue" onclick="window.location.reload();">Atualizar Tabela</button>
            </div>

            <div class="table-container">
                <table class="os-table" id="osTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Abertura</th>
                            <th>Fechamento</th>
                            <th>Cliente</th>
                            <th>Aparelho</th>
                            <th>Valor (R$)</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                       <?php echo listarOs() ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal-overlay" id="statusModal">
        <div class="modal-content" >
            <h3 >Alterar Status Ordem de Serviço</h3>
            <form action="php/atualizarStatusOs.php" method="GET">
                <input type="hidden" id="statusIdOs" name="id">
                
                <div class="form-group" style="margin: 20px 0;">
                    <label for="modalNovoStatus" style="display: block; margin-bottom: 8px;">Selecione a opção:</label>
                    <select id="modalNovoStatus" name="status" required style="width: 100%; height: 35px; border-radius: 4px; background-color: #102a43; color: white; border: 1px solid #2cb1bc; padding: 0 5px;">
                        <option value="andamento">Em Andamento</option>
                        <option value="pronto">Aguardando Retirada</option>
                        <option value="finalizado">Finalizado</option>
                        <option value="Devolvido">Sem conserto(devolvido)</option>
                    </select>
                </div>
                <div class="modal-buttons" style="display: flex; gap: 10px; justify-content: flex-end;">
                    <button type="submit" class="btn btn-sucesso">Confirmar</button>
                    <button type="button" class="btn btn-red" id="btnFecharStatusModal">Cancelar</button>
                </div>
            </form>
        </div>
    </div>

    <div class="modal-overlay" id="confirmModal">
        <div class="modal-content">
            <h3>Confirmação de Exclusão</h3>
            <p id="modalMessage">Tem certeza que deseja excluir o item selecionado?</p>
            <div class="modal-buttons">
                <button type="button" class="btn btn-red" id="confirmDelete">Sim, Excluir</button>
                <button type="button" class="btn btn-blue" id="cancelDelete">Cancelar</button>
            </div>
        </div>
    </div>

    <script src="js/os.js"></script>

</body>
</html>
