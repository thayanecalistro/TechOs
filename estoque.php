<?php
session_start();

include("php/funcoes.php");
$currentPage = 'estoque';
require_once('includes/conexao.php');

$pesquisa = '';
if (isset($_POST['busca']) && !empty(trim($_POST['busca']))) {
    $pesquisa = trim($_POST['busca']);
}

$linhasTabelaEstoque = listarProdutosEstoque($conn, $pesquisa);

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechOS - Estoque</title>
    <link rel="stylesheet" href="css/style_geral.css"> 
    <link rel="stylesheet" href="css/estoque.css">
    <link rel="stylesheet" href="css/style_cadastros.css">
</head>
<body>
    <?php include('sidebar.php'); ?>

    <div class="page-content">       
        <div class="os-header">
            <div>
                <h2>Controle de Estoque</h2>
            </div>
        </div>

        <fieldset class="search-fieldset">
            <legend>Pesquisar</legend>
            <form method="POST" action="estoque.php" id="formBusca">
                <div class="search-box">
                    <input type="text" id="pesquisar" name="busca" value="<?= htmlspecialchars($pesquisa) ?>" placeholder="ID, Fornecedor ou Peça...">
                    <button type="submit" class="btn btn-blue" id="btnBuscar">Buscar</button>
                    <a href="estoque.php" class="btn btn-cyan">Limpar</a>
                </div>
            </form>
        </fieldset>

        <div class="section-card">

        <div class="footer-actions">
        <button type="button" class="btn btn-sucesso" onclick="abrirModalEstoque()">Novo</button>
        </div>
        

            <div class="table-container">
                <table class="os-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Fornecedor</th>
                            <th>Peça</th>
                            <th>Valor Unitário</th>
                            <th>Quantidade</th>
                            <th>Total (R$)</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php echo $linhasTabelaEstoque; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- MODAL DE CADASTRO / EDIÇÃO DE ESTOQUE -->
    <div id="modalEstoque" class="modal">
        <div class="modal-conteudo">
            <span class="botaoFechar" onclick="fecharModalEstoque()">&times;</span>
            <h2 id="tituloModalEstoque">Cadastro de Item</h2>

            <form id="formEstoque" method="POST" action="php/salvarEstoque.php">
                <input type="hidden" name="idEstoque" id="idEstoque" value="">

                <div class="linhaFormulario">
                    <div class="grupo-input">
                        <label for="NomeFornecedor">Fornecedor</label>
                        <input type="text" name="NomeFornecedor" id="NomeFornecedor" required>
                    </div>
                    <div class="grupo-input">
                        <label for="peca">Peça</label>
                        <input type="text" name="peca" id="peca" required>
                    </div>
                </div>

                <div class="linhaFormulario">
                    <div class="grupo-input">
                        <label for="valor">Valor Unitário (R$)</label>
                        <input type="number" step="0.01" id="valor" name="valor" oninput="calcularTotal()" required>
                    </div>
                    <div class="grupo-input">
                        <label for="qtd">Quantidade</label>
                        <input type="number" id="qtd" name="quantidade" oninput="calcularTotal()" required>
                    </div>
                </div>

                <div class="linhaFormulario">
                    <div class="grupo-input">
                        <label for="total">Total (R$)</label>
                        <input type="number" step="0.01" id="total" name="total" readonly>
                    </div>
                </div>

                <div class="botaoContainer">
                    <input type="submit" value="Salvar" id="botaoSalvar">
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL DE VISUALIZAR ESTOQUE -->
    <div id="modalEstoqueVisualizar" class="modal">
        <div class="modal-conteudo">
            <span class="botaoFechar" onclick="fecharModalVisualizarEstoque()">&times;</span>
            <h2>Dados do Item do Estoque</h2>

            <div class="linhaFormulario">
                <div class="grupo-input">
                    <label><strong>ID: </strong></label>
                    <span id="txtIdEstoque"></span>
                </div>
                <div class="grupo-input">
                    <label><strong>Fornecedor: </strong></label>
                    <span id="txtFornecedorEstoque"></span>
                </div>
            </div>

            <div class="linhaFormulario">
                <div class="grupo-input">
                    <label><strong>Peça: </strong></label>
                    <span id="txtPecaEstoque"></span>
                </div>
                <div class="grupo-input">
                    <label><strong>Valor Unitário: </strong></label>
                    <span id="txtValorEstoque"></span>
                </div>
            </div>

            <div class="linhaFormulario">
                <div class="grupo-input">
                    <label><strong>Quantidade: </strong></label>
                    <span id="txtQtdEstoque"></span>
                </div>
                <div class="grupo-input">
                    <label><strong>Total: </strong></label>
                    <span id="txtTotalEstoque"></span>
                </div>
            </div>
        </div>
    </div>
        
                    <!--MODAL DE CONFIRMAÇÃO DE EXCLUSÃO-->
    <div class="modal-overlay" id="confirmarExcluirModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.75); justify-content: center; align-items: center; z-index: 9999;">
        <div class="modal-content" style="background: #0c1f32; padding: 25px; border-radius: 6px; width: 380px; border: 1px solid #ff4d4d; color: white; text-align: center;">
            <h3 style="margin-top: 0; color: #ff4d4d;">Atenção!</h3>
            <p style="margin: 20px 0; font-size: 15px; line-height: 1.5;">
                Deseja realmente excluir o orçamento <strong id="textoIdExcluir" style="color: #62b6cb;"></strong>?<br>
                <span style="font-size: 12px; color: #ffb3b3;">Esta ação não poderá ser desfeita.</span>
            </p>
            <div style="display: flex; gap: 12px; justify-content: center; margin-top: 20px;">
                <button type="button" class="btn btn-red" id="btnConfirmarExclusaoDefinitiva" style="padding: 8px 20px; font-weight: bold;">Sim, Excluir</button>
                <button type="button" class="btn" id="btnCancelarExclusao" style="background: #486581; color: white; padding: 8px 20px;">Cancelar</button>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/estoque.js"></script>
</body>
</html>