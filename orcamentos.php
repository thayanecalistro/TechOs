<?php

include("php/funcoes.php");

$currentPage = 'orcamento';
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechOS - Orçamentos</title>

    <link rel="stylesheet" href="css/style_geral.css"> 
    <link rel="stylesheet" href="css/style_orcamento.css"> 
</head>
<body>

    <?php include('sidebar.php'); ?>

    <div class="page-content">
        
        <div class="os-header">
            <div>
                <h2>Controle de Orçamentos</h2>
            </div>
            <button type="button" class="btn btn-sucesso" id="btnNovoOrcamento">+ Novo</button>
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
        <!--<div class="footer-actions">
                <button type="button" class="btn btn-light-blue" onclick="window.location.reload();">Atualizar Tabela</button>
            </div>-->

            <div class="table-container">
                <table class="os-table" id="orcamentoTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Cliente (ID)</th>
                            <th>Aparelho (ID)</th>
                            <th>Peça</th>
                            <th>V. Unit (R$)</th>
                            <th>Mão de Obra (R$)</th>
                            <th>V. Total (R$)</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php echo listarOrcamentos(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal-overlay" id="cadastroModal">
        <div class="modal-content modal-large">
            <h3>Cadastrar Novo Orçamento</h3>
            <form id="formOrcamento" action="php/salvarOrcamento.php?opcao=I" method="POST">
                <div class="form-grid">

                    <div class="form-group">
                        <label for="cliente_busca">Nome do Cliente *</label>
                        <input type="text" id="cliente_busca" list="listaClientes" required placeholder="Digite o nome do cliente..." autocomplete="off">
                        <input type="hidden" id="Cliente_idCliente" name="Cliente_idCliente" required>
                        <datalist id="listaClientes">
                            <?php echo comboClientes(); ?>
                        </datalist>
                    </div>

                    <div class="form-group">
                        <label for="Aparelho_idAparelho">Aparelho *</label>
                        <select id="Aparelho_idAparelho" name="Aparelho_idAparelho" required style="width: 100%; height: 35px; border-radius: 4px; background-color: #0c1f32; color: white; border: 1px solid #2cb1bc;">
                            <option value="">Selecione primeiro o cliente...</option>
                        </select>
                    </div>

                    <div class="form-group full-width">
                        <label for="diagnostico">Diagnóstico Técnico</label>
                        <textarea id="diagnostico" name="nDiagnostico" rows="2" placeholder="Avaliação técnica inicial..."></textarea>
                    </div>

                    <div class="form-group full-width" style="border: 1px dashed #2cb1bc; padding: 15px; border-radius: 4px;">
                        <label style="font-weight: bold; margin-bottom: 10px; display: block;">Peças Necessárias</label>
                        <div id="container-pecas">
                            <div class="peca-row" style="display: flex; gap: 10px; margin-bottom: 10px;">
                                <input type="text" name="nPeca[]" class="classe-busca-peca" list="listaPecasEstoque" placeholder="Busque a peça no estoque..." style="flex: 2;" required autocomplete="off">
                                <input type="hidden" name="nIdEstoque[]" class="classe-id-estoque">
                                
                                <input type="number" name="nValorUni[]" class="classe-val-uni" step="0.01" value="0.00" style="flex: 1;" placeholder="Valor Unit." readonly style="background-color: #0c1f32; color: #2cb1bc;">
                                <input type="number" name="nQtd[]" class="classe-qtd" value="1" min="1" style="width: 70px;">
                            </div>
                        </div>
                        <button type="button" id="btnAdicionarPeca" class="btn btn-cyan" style="padding: 5px 10px; font-size: 12px; margin-top: 5px;">+ Adicionar Peça</button>
                    </div>

                    <datalist id="listaPecasEstoque">
                        <?php
                        include("php/conexao.php");
                        // Seleciona peças que tenham quantidade maior que zero no estoque
                        $resEstoque = mysqli_query($conn, "SELECT idEstoque, peca, valor FROM estoque WHERE quantidade > 0");
                        while($reg = mysqli_fetch_assoc($resEstoque)){
                            echo "<option value='".htmlspecialchars($reg['peca'], ENT_QUOTES)."' data-id='".$reg['idEstoque']."' data-valor='".$reg['valor']."'>";
                        }
                        ?>
                    </datalist>

                    <div class="form-group">
                        <label for="maoObra">Mão de Obra (R$)</label>
                        <input type="number" id="maoObra" name="nMaoObra" step="0.01" value="0.00">
                    </div>

                    <div class="form-group">
                        <label for="status">Status</label>
                        <select id="status" name="nStatus">
                            <option value="aberto" selected>Aberto</option>
                        <!--<option value="aprovado">Aprovado</option>
                            <option value="reprovado">Reprovado</option>
                            <option value="finalizado">Finalizado</option>-->
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="valorTotal">Valor Total (R$)</label>
                        <input type="number" id="valorTotal" name="nTotal" step="0.01" value="0.00" readonly style="background-color: #0c1f32; font-weight: bold; color: #2cb1bc;">
                    </div>
                </div>

                <div class="modal-buttons">
                    <button type="submit" class="btn btn-sucesso">Salvar Orçamento</button>
                    <button type="button" class="btn btn-red" id="btnFecharModal">Cancelar</button>
                </div>
            </form>
        </div>
    </div>

                    <!--MODAL DE STATUS-->
    <div class="modal-overlay" id="statusModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.6); justify-content: center; align-items: center; z-index: 9999;">
        <div class="modal-content" style="background: #0c1f32; padding: 20px; border-radius: 6px; width: 350px; border: 1px solid #2cb1bc; color: white;">
            <h3 style="margin-top: 0; color: #62b6cb;">Alterar Status do Orçamento</h3>
            <form action="php/atualizarStatus.php" method="GET">
                <input type="hidden" id="statusIdOrcamento" name="id">
                
                <div class="form-group" style="margin: 20px 0;">
                    <label for="modalNovoStatus" style="display: block; margin-bottom: 8px;">Selecione a opção:</label>
                    <select id="modalNovoStatus" name="status" required style="width: 100%; height: 35px; border-radius: 4px; background-color: #102a43; color: white; border: 1px solid #2cb1bc; padding: 0 5px;">
                        <option value="aprovado">Aprovado</option>
                        <option value="reprovado">Recusado</option>
                    </select>
                </div>
                <div class="modal-buttons" style="display: flex; gap: 10px; justify-content: flex-end;">
                    <button type="submit" class="btn btn-sucesso">Confirmar</button>
                    <button type="button" class="btn btn-red" id="btnFecharStatusModal">Cancelar</button>
                </div>
            </form>
        </div>
    </div>

                    <!--MODAL DE VISUALIZAÇÃO-->
    <div class="modal-overlay" id="detalhesModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.6); justify-content: center; align-items: center; z-index: 9998;">
        <div class="modal-content" style="background: #1a304a; padding: 25px; border-radius: 6px; width: 500px; border: 1px solid #2cb1bc; color: white;">
            <h3 style="margin-top: 0; color: #62b6cb; border-bottom: 1px solid #334e68; padding-bottom: 10px;">Detalhes do Orçamento <span id="viewIdOrcamento" style="color: white;"></span></h3>
            
            <div style="margin: 20px 0; display: flex; flex-direction: column; gap: 12px;">
                <div class="form-group">
                    <label style="display:block; margin-bottom:4px; font-weight:500;">Cliente:</label>
                    <input type="text" id="viewCliente" readonly style="width:100%; height:35px; background:#0c1f32; color:#fff; border:1px solid #486581; border-radius:4px; padding:0 10px;">
                </div>
                <div class="form-group">
                    <label style="display:block; margin-bottom:4px; font-weight:500;">Aparelho / Modelo:</label>
                    <input type="text" id="viewAparelho" readonly style="width:100%; height:35px; background:#0c1f32; color:#fff; border:1px solid #486581; border-radius:4px; padding:0 10px;">
                </div>
                <div class="form-group">
                    <label style="display:block; margin-bottom:4px; font-weight:500;">Peças Vinculadas:</label>
                    <input type="text" id="viewPecas" readonly style="width:100%; height:35px; background:#0c1f32; color:#fff; border:1px solid #486581; border-radius:4px; padding:0 10px;">
                </div>
                <div style="display: flex; gap: 10px;">
                    <div class="form-group" style="flex: 1;">
                        <label style="display:block; margin-bottom:4px; font-weight:500;">Mão de Obra (R$):</label>
                        <input type="text" id="viewMaoObra" readonly style="width:100%; height:35px; background:#0c1f32; color:#fff; border:1px solid #486581; border-radius:4px; padding:0 10px;">
                    </div>
                    <div class="form-group" style="flex: 1;">
                        <label style="display:block; margin-bottom:4px; font-weight:500;">Valor Total (R$):</label>
                        <input type="text" id="viewTotal" readonly style="width:100%; height:35px; background:#0c1f32; color:#fff; border:1px solid #486581; border-radius:4px; padding:0 10px; font-weight:bold;">
                    </div>
                </div>
                <div class="form-group">
                    <label style="display:block; margin-bottom:4px; font-weight:500;">Status Atual:</label>
                    <input type="text" id="viewStatus" readonly style="width:100%; height:35px; background:#0c1f32; color:#fff; border:1px solid #486581; border-radius:4px; padding:0 10px;">
                </div>
            </div>

            <div style="display: flex; gap: 10px; justify-content: space-between; margin-top: 20px; border-top: 1px solid #334e68; padding-top: 15px;">
                <div>
                    <button type="button" class="btn btn-cyan" id="btnAcaoEditar" style="padding: 8px 15px; margin-right: 5px;">Editar</button>
                    <button type="button" class="btn btn-red" id="btnAcaoExcluir" style="padding: 8px 15px;">Excluir</button>
                </div>
                <button type="button" class="btn" id="btnFecharDetalhesModal" style="background: #486581; color: white; padding: 8px 15px;">Fechar</button>
            </div>
        </div>
    </div>

    <script src="js/orcamento.js"></script>
</body>
</html>