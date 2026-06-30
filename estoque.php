<?php
// estoque.php
$currentPage = 'estoque';
require_once('includes/conexao.php');

$pesquisa = '';
if (isset($_POST['busca']) && !empty(trim($_POST['busca']))) {
    $pesquisa = trim($_POST['busca']);
}

$produtos = [];
if (!empty($pesquisa)) {
    $sql_busca = "SELECT * FROM estoque WHERE NomeFornecedor LIKE ? OR peca LIKE ? ORDER BY idEstoque DESC";
    $stmt = mysqli_prepare($conn, $sql_busca);
    $param = "%" . $pesquisa . "%";
    mysqli_stmt_bind_param($stmt, "ss", $param, $param);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);
} else {
    $sql_busca = "SELECT * FROM estoque ORDER BY idEstoque DESC";
    $resultado = mysqli_query($conn, $sql_busca);
}

if ($resultado && mysqli_num_rows($resultado) > 0) {
    while ($linha = mysqli_fetch_assoc($resultado)) {
        $produtos[] = $linha;
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Controle de Estoque</title>
    <link rel="stylesheet" href="css/estoque.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
    <?php include('sidebar.php'); ?>

    <div class="page-content">
        <div class="header-top">
            <h2>Estoque</h2>
            <button type="button" class="btn-novo btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalEstoque">Novo</button>
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
                    <?php if (!empty($produtos)): ?>
                        <?php foreach ($produtos as $prod): ?>
                            <tr>
                                <td><?= $prod['idEstoque'] ?></td>
                                <td><?= htmlspecialchars($prod['NomeFornecedor']) ?></td>
                                <td><?= htmlspecialchars($prod['peca']) ?></td>
                                <td>R$ <?= number_format($prod['valor'], 2, ',', '.') ?></td>
                                <td><?= $prod['quantidade'] ?></td>
                                <td>R$ <?= number_format($prod['total'], 2, ',', '.') ?></td>
                                <td>
                                    <button type="button" class="acao-editar btn btn-sm btn-warning" 
                                        data-id="<?= $prod['idEstoque'] ?>"
                                        data-fornecedor="<?= htmlspecialchars($prod['NomeFornecedor']) ?>"
                                        data-peca="<?= htmlspecialchars($prod['peca']) ?>"
                                        data-valor="<?= $prod['valor'] ?>"
                                        data-quantidade="<?= $prod['quantidade'] ?>"
                                        data-total="<?= $prod['total'] ?>">Editar</button>
                                    
                                    <a href="salvarEstoque.php?excluir_id=<?= $prod['idEstoque'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Deseja realmente excluir?')">Excluir</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="7" class="sem-dados text-center">Nenhum item em estoque.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="modalEstoque" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="formEstoque" method="POST" action="salvarEstoque.php">
                    <div class="modal-header">
                        <h5 class="modal-title" id="tituloModalEstoque">Novo Item no Estoque</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="idEstoque" id="idEstoque" value="">
                        
                        <div class="mb-3">
                            <label class="form-label">Fornecedor</label>
                            <input type="text" name="NomeFornecedor" id="NomeFornecedor" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Peça</label>
                            <input type="text" name="peca" id="peca" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Valor Unitário (R$)</label>
                            <input type="number" step="0.01" id="valor" name="valor" class="form-control" oninput="calcularTotal()" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Quantidade</label>
                            <input type="number" id="qtd" name="quantidade" class="form-control" oninput="calcularTotal()" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Total (R$)</label>
                            <input type="number" step="0.01" id="total" name="total" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/estoque.js"></script>
</body>
</html>