<?php
// estoque.php
include("php/funcoes.php");
$currentPage = 'estoque';
require_once('php/conexao.php');

$pesquisa = '';
if (isset($_POST['busca']) && !empty(trim($_POST['busca']))) {
    $pesquisa = trim($_POST['busca']);
}


?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Controle de Estoque</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/os.css">
    <link rel="stylesheet" href="css/style_orcamento.css">

</head>
<body>
    <?php include('sidebar.php'); ?>

    <div class="page-content">
        <div class="os-header">
            <div>
                <h2>Estoque</h2>
            </div>
            <button type="button" class="btn btn-sucesso" data-bs-toggle="modal" data-bs-target="#modalEstoque">Novo</button>
        </div>
        <hr>

        <div class="pesquisa-container">
            <form method="POST" action="estoque.php">
                <input type="text" name="busca" value="<?= htmlspecialchars($pesquisa) ?>" placeholder="ID, Fornecedor ou Peça..." class="input-pesquisa">
                <button type="submit" class="btn-buscar">Buscar</button>
                <a href="estoque.php" class="btn-limpar">Limpar</a>
            </form>
        </div>

        <div class="tabela-container mt-4">
            <table class="tabela-estoque table table-striped">
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
                    <?php echo listarProdutosEstoque() ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="modalEstoque">
        <div class="modal-dialog  modal-large" >
            <div class="modal-content">
                <div class="modal-header">
                    <h3 id="tituloModalEstoque">Novo Item</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="close"></button>
                </div>
                <form id="formEstoque" method="POST" action="php/salvarEstoque.php">
                    <div class="modal-body">
                        
                        <div class="form-grid">
                        <input type="hidden" name="idEstoque" id="idEstoque" value="">
                            <div class="form-group">
                                <label class="form-label">Fornecedor</label>
                                <input type="text" name="NomeFornecedor" id="NomeFornecedor" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Peça</label>
                                <input type="text" name="peca" id="peca" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Valor Unitário (R$)</label>
                                <input type="number" step="0.01" id="valor" name="valor" class="form-control" oninput="calcularTotal()" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Quantidade</label>
                                <input type="number" id="qtd" name="quantidade" class="form-control" oninput="calcularTotal()" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Total (R$)</label>
                                <input type="number" step="0.01" id="total" name="total" class="form-control" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn badge-reprovado" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn badge-aprovado">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/estoque.js"></script>
</body>
</html>