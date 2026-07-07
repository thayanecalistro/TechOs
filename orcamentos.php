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

    <link rel="stylesheet" href="css/os.css"> 
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
                <button type="button" class="btn btn-red" id="btnExcluir">Excluir</button>
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
                            <option value="aprovado">Aprovado</option>
                            <option value="reprovado">Reprovado</option>
                            <option value="finalizado">Finalizado</option>
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

    <script src="js/orcamento.js"></script>
</body>

<!--?php foreach ($orcamentos as $orc): ?>
                            <tr>
                                <td>?= $orc['idOrcamento']; ?></td>
                                <td>?= $orc['Cliente_idCliente']; ?></td>
                                <td>?= $orc['Aparelho_idAparelho']; ?></td>
                                <td>?= $orc['peca']; ?></td>
                                <td>?= $orc['valorUni']; ?></td>
                                <td>?= $orc['maoObra']; ?></td>
                                <td><strong>?= $orc['valorTotal']; ?></strong></td>
                                <td><span class="badge badge-?= $orc['status']; ?>">?= $orc['status']; ?></span></td>
                            </tr>
                        ?php endforeach; ?>
                        
                        <div class="form-group">
                        <label for="Clientes_idCliente">Nome do Cliente *</label>
                        <select name="Clientes_idCliente" id="Clientes_idCliente" required style="width: 100%; 
                                      height: 35px; border-radius: 4px; background-color: #0c1f32; color: white; 
                                      border: 1px solid #2cb1bc;">
                                      ?php echo comboClientes(); ?>
                        </select>
                    </div>
                    
                    <div class="form-group full-width">
                        <label for="diagnostico">Diagnóstico Técnico</label>
                        <textarea id="diagnostico" name="diagnostico" rows="2" placeholder="Avaliação técnica inicial..."></textarea>
                    </div>-->
</html>