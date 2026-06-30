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
    <title>TechOS - Controle de Estoque</title>

    <link rel="stylesheet" href="css/os.css">
    <link rel="stylesheet" href="css/style_estoque.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
    <?php include('sidebar.php'); ?>

    <div class="page-content">
        <div class="os-header">
            <h2>Controle de Estoque</h2>
            <button type="button" class="btn-novo" data-bs-toggle="modal" data-bs-target="#modalEstoque">Novo Item</button>
        </div>

        <div class="table-section">
            <fieldset class="search-fieldset">
                <legend>Pesquisar no Estoque</legend>
                <div class="search-box">
                    <form method="POST" action="estoque.php" class="d-flex gap-2 w-100 align-items-center flex-wrap">
                        <input type="text" name="busca" value="<?= htmlspecialchars($pesquisa) ?>" placeholder="ID, Fornecedor ou Peça..." class="input-pesquisa">
                        <button type="submit" class="btn btn-blue">Buscar</button>
                        <a href="estoque.php" class="btn-limpar">Limpar Filtro</a>
                    </form>
                </div>
            </fieldset>

            <div class="table-card-fundo">
                <div class="table-container"> 
                    <table class="dashboard-table">
                        <thead>
                            <tr>
                                <th scope="col" style="width: 8%;">ID</th>
                                <th scope="col">Fornecedor</th>
                                <th scope="col">Peça</th>
                                <th scope="col" style="width: 15%;">Valor Unitário</th>
                                <th scope="col" style="width: 12%;">Quantidade</th>
                                <th scope="col" style="width: 15%;">Total (R$)</th>
                                <th scope="col" style="width: 15%; text-align: center;">Ações</th>
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
                                        <td class="col-total-destaque">R$ <?= number_format($prod['total'], 2, ',', '.') ?></td>
                                        <td style="text-align: center;">
                                            <button type="button" class="acao-editar" 
                                                data-id="<?= $prod['idEstoque'] ?>"
                                                data-fornecedor="<?= htmlspecialchars($prod['NomeFornecedor']) ?>"
                                                data-peca="<?= htmlspecialchars($prod['peca']) ?>"
                                                data-valor="<?= $prod['valor'] ?>"
                                                data-quantidade="<?= $prod['quantidade'] ?>"
                                                data-total="<?= $prod['total'] ?>">Editar</button>
                                            
                                            <a href="salvarEstoque.php?excluir_id=<?= $prod['idEstoque'] ?>" class="acao-excluir" onclick="return confirm('Deseja realmente excluir este item?')">Excluir</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="7" class="sem-dados">Nenhum item localizado no estoque.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalEstoque" unset-styles>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="tituloModalEstoque">Novo Item no Estoque</h3>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formEstoque" method="POST" action="salvarEstoque.php">
                    <div class="modal-body">
                        <input type="hidden" name="idEstoque" id="idEstoque" value="">

                        <div class="linhaFormulario">
                            <div class="input-grupo">
                                <label class="form-label">Fornecedor</label>
                                <input type="text" name="NomeFornecedor" id="NomeFornecedor" placeholder="Ex: Distribuidora Oficial" required>
                            </div>
                        </div>

                        <div class="linhaFormulario">
                            <div class="input-grupo">
                                <label class="form-label">Peça</label>
                                <input type="text" name="peca" id="peca" placeholder="Ex: Tela Frontal Display" required>
                            </div>
                        </div>

                        <div class="linhaFormulario">
                            <div class="input-grupo">
                                <label class="form-label">Valor Unitário (R$)</label>
                                <input type="number" step="0.01" id="valor" name="valor" placeholder="0.00" oninput="calcularTotal()" required>
                            </div>
                            <div class="input-grupo" style="flex: 0.5;">
                                <label class="form-label">Quantidade</label>
                                <input type="number" id="qtd" name="quantidade" min="1" placeholder="1" oninput="calcularTotal()" required>
                            </div>
                        </div>

                        <div class="linhaFormulario" style="margin-top: 15px;">
                            <div class="input-grupo">
                                <label class="form-label" style="color: #2cb1bc; font-weight: bold;">Cálculo Total Geral</label>
                                <input type="number" step="0.01" id="total" name="total" style="color: #2cb1bc; font-weight: bold; background-color: #0b1a29;" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn-secundario" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn-principal">Salvar Registro</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/estoques.js"></script>
</body>
</html>