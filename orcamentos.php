<?php
$currentPage = 'orcamento';

// Simulação de dados vindos do banco de dados (Baseado na sua tabela 'orcamento')
$orcamentos = [
    [
        "idOrcamento" => 1,
        "diagnostico" => "Tela quebrada após queda",
        "peca" => "Tela Frontal Samsung A22",
        "valorUni" => "120.00",
        "maoObra" => "80.00",
        "valorTotal" => "200.00",
        "status" => "aprovado",
        "OS_idOS" => 1,
        "Cliente_idCliente" => 1,
        "Aparelho_idAparelho" => 1,
        "dataOrcamento" => "2025-12-03 21:40:53"
    ],
    [
        "idOrcamento" => 2,
        "diagnostico" => "Conector de carga danificado",
        "peca" => "Conector Tipo-C Apple 15",
        "valorUni" => "150.00",
        "maoObra" => "280.00",
        "valorTotal" => "430.00",
        "status" => "aberto",
        "OS_idOS" => "None",
        "Cliente_idCliente" => 2,
        "Aparelho_idAparelho" => 2,
        "dataOrcamento" => "2025-12-03 21:42:15"
    ]
];
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechOS - Orçamentos</title>
    <link rel="stylesheet" href="css/os.css"> <link rel="stylesheet" href="css/style_orcamento.css"> </head>
<body>

    <?php include('sidebar.php'); ?>

    <div class="page-content">
        
        <div class="os-header">
            <div>
                <h2>Controle de Orçamentos</h2>
            </div>
            <button type="button" class="btn btn-sucesso" id="btnNovoOrcamento">+ Novo Orçamento</button>
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
                        <?php foreach ($orcamentos as $orc): ?>
                            <tr>
                                <td><?= $orc['idOrcamento']; ?></td>
                                <td><?= $orc['Cliente_idCliente']; ?></td>
                                <td><?= $orc['Aparelho_idAparelho']; ?></td>
                                <td><?= $orc['peca']; ?></td>
                                <td><?= $orc['valorUni']; ?></td>
                                <td><?= $orc['maoObra']; ?></td>
                                <td><strong><?= $orc['valorTotal']; ?></strong></td>
                                <td><span class="badge badge-<?= $orc['status']; ?>"><?= $orc['status']; ?></span></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal-overlay" id="cadastroModal">
        <div class="modal-content modal-large">
            <h3>Cadastrar Novo Orçamento</h3>
            <form id="formOrcamento" action="#" method="POST">
                <div class="form-grid">
                    <div class="form-group">
                        <label for="Cliente_idCliente">Nome do Cliente *</label>
                        <input type="number" id="Cliente_idCliente" name="Cliente_idCliente" required placeholder="Ex: 1">
                    </div>

                    <div class="form-group">
                        <label for="Aparelho_idAparelho">Aparelho *</label>
                        <input type="number" id="Aparelho_idAparelho" name="Aparelho_idAparelho" required placeholder="Ex: 3">
                    </div>

                    <div class="form-group full-width">
                        <label for="diagnostico">Diagnóstico Técnico</label>
                        <textarea id="diagnostico" name="diagnostico" rows="2" placeholder="Avaliação técnica inicial..."></textarea>
                    </div>

                    <div class="form-group full-width">
                        <label for="peca">Peças Necessárias</label>
                        <input type="text" id="peca" name="peca" placeholder="Descrição das peças principais...">
                    </div>

                    <div class="form-group">
                        <label for="valorUni">Valor Unitário Peças (R$)</label>
                        <input type="number" id="valorUni" name="valorUni" step="0.01" value="0.00">
                    </div>

                    <div class="form-group" style="flex: 0.5;">
                        <label class="form-label">Qtd:</label>
                        <input type="number" value="1" min="1" name="nQtd" id="modal-qtd-peca">
                    </div>

                    <div class="form-group">
                        <label for="maoObra">Mão de Obra (R$)</label>
                        <input type="number" id="maoObra" name="maoObra" step="0.01" value="0.00">
                    </div>

                    <div class="form-group">
                        <label for="status">Status</label>
                        <select id="status" name="status">
                            <option value="aberto" selected>Aberto</option>
                            <option value="aprovado">Aprovado</option>
                            <option value="reprovado">Reprovado</option>
                            <option value="finalizado">Finalizado</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="valorTotal">Valor Total (R$)</label>
                        <input type="number" id="valorTotal" name="valorTotal" step="0.01" value="0.00" readonly style="background-color: #0c1f32; font-weight: bold; color: #2cb1bc;">
                    </div>
                </div>

                <div class="modal-buttons">
                    <button type="submit" class="btn btn-sucesso">Salvar Orçamento</button>
                    <button type="button" class="btn btn-red" id="btnFecharModal">Cancelar</button>
                </div>
            </form>
        </div>
    </div>

    <script src="js/orcamentos.js"></script>
</body>
</html>