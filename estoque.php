<?php
// 1. CONEXÃO COM O BANCO DE DADOS
require_once('includes/conexao.php');

// Inicializa a variável de pesquisa para não dar erro na tela
$pesquisa = isset($_POST['busca']) ? mysqli_real_escape_string($conexao, $_POST['busca']) : '';

// 2. PROCESSA O CADASTRO (Quando o usuário clica em "Cadastrar")
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['NomeFornecedor'])) {
    $NomeFornecedor = mysqli_real_escape_string($conexao, $_POST['NomeFornecedor']);
    $peca = mysqli_real_escape_string($conexao, $_POST['peca']);
    $valor = floatval($_POST['valor']);
    $quantidade = intval($_POST['quantidade']);

    // Calcula o total no PHP antes de salvar no banco
    $total = $valor * $quantidade;

    // Insere os dados na tabela 'Estoque' (o idEstoque é gerado automaticamente)
    $sql_insert = "INSERT INTO estoque (NomeFornecedor, peca, valor, quantidade, total) 
                   VALUES ('$NomeFornecedor', '$peca', '$valor', '$quantidade', '$total')";
    
    if (mysqli_query($conexao, $sql_insert)) {
        // Redireciona para si mesmo para evitar que o formulário seja reenviado ao atualizar a página
        header("Location: estoque.php");
        exit;
    } else {
        echo "Erro ao salvar no banco: " . mysqli_error($conexao);
    }
}

// 3. PROCESSA A EXCLUSÃO (Quando o usuário clica no botão Excluir de uma linha)
if (isset($_GET['excluir'])) {
    $id_excluir = intval($_GET['excluir']);
    $sql_delete = "DELETE FROM Estoque WHERE idEstoque = $id_excluir";
    
    if (mysqli_query($conexao, $sql_delete)) {
        header("Location: estoque.php");
        exit;
    } else {
        echo "Erro ao excluir item: " . mysqli_error($conexao);
    }
}

// 4. SISTEMA DE BUSCA / LISTAGEM (Traz os dados para a tabela)
if (!empty($pesquisa)) {
    // Se o usuário buscou algo, filtra por Fornecedor ou Peça
    $sql_busca = "SELECT * FROM Estoque WHERE NomeFornecedor LIKE '%$pesquisa%' OR peca LIKE '%$pesquisa%' ORDER BY idEstoque DESC";
} else {
    // Se não buscou nada, traz todos os produtos organizados pelo mais recente
    $sql_busca = "SELECT * FROM Estoque ORDER BY idEstoque DESC";
}

$resultado = mysqli_query($conexao, $sql_busca);

$produtos = [];
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
    
    <script>
        // Função Javascript que calcula o total em tempo real na tela
        function calcularTotal() {
            var valor = parseFloat(document.getElementById('valor').value) || 0;
            var qtd = parseInt(document.getElementById('qtd').value) || 0;
            var total = valor * qtd;
            document.getElementById('total').value = total.toFixed(2);
        }
    </script>
</head>
<body>
    <div class="container">
        <h2>Listagem de Estoque</h2>

        <div class="card-custom">
            <h5 class="card-title">Cadastrar Item no Estoque</h5>

            <form action="estoque.php" method="POST">
                <div class="form-grid">

                    <div class="form-group">
                        <label>Fornecedor: </label>
                        <input type="text" name="NomeFornecedor" class="form-control-custom" required>
                    </div>

                    <div class="form-group">
                        <label>Peça: </label>
                        <input type="text" name="peca" class="form-control-custom" required>
                    </div>

                    <div class="form-group">
                        <label>Preço Unitário (R$): </label>
                        <input type="number" step="0.01" id="valor" name="valor" class="form-control-custom" oninput="calcularTotal()" required>
                    </div>

                    <div class="form-group">
                        <label>Quantidade: </label>
                        <input type="number" id="qtd" name="quantidade" class="form-control-custom" oninput="calcularTotal()" required>
                    </div>

                    <div class="form-group">
                        <label>Total: </label>
                        <input type="number" step="0.01" name="total" id="total" class="form-control-custom" readonly>
                    </div>
                </div>

                <div class="btn-group">
                    <button type="submit" class="btn-custom btn-success-custom">Cadastrar</button>
                    <button type="button" class="btn-custom btn-warning-custom">Alterar</button>
                </div>
            </form>
        </div>

        <div class="card-custom">
            <form method="POST" action="estoque.php">
                <div class="search-container">
                    <div class="form-group search-input-group">
                        <label>Pesquisar</label>
                        <input type="text" name="busca" value="<?php echo htmlspecialchars($pesquisa); ?>" placeholder="Digite o fornecedor ou peça...">
                    </div>
                    <button type="submit" class="btn-custom btn-info-custom" style="height: 41px; width: 120px;">Pesquisar</button>
                </div>
            </form>
        </div>

        <table class="table-custom">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Fornecedor</th>
                    <th>Peça</th>
                    <th>Preço Unitário</th>
                    <th>Quantidade</th>
                    <th>Total (R$)</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($produtos)): ?>
                    <?php foreach ($produtos as $prod): ?>
                        <tr>
                            <td><?php echo $prod['idEstoque']; ?></td>
                            <td><?php echo htmlspecialchars($prod['NomeFornecedor']); ?></td>
                            <td><?php echo htmlspecialchars($prod['peca']); ?></td>
                            <td>R$ <?php echo number_format($prod['valor'], 2, ',', '.'); ?></td>
                            <td><?php echo $prod['quantidade']; ?></td>
                            <td>R$ <?php echo number_format($prod['total'], 2, ',', '.'); ?></td>
                            <td>
                                <a href="estoque.php?excluir=<?php echo $prod['idEstoque']; ?>" 
                                   onclick="return confirm('Tem certeza que deseja excluir este item do estoque?')" 
                                   style="color: red; text-decoration: none; font-weight: bold;">
                                   Excluir
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" style="text-align:center;">Nenhum produto encontrado no estoque.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <div class="btn-group" style="margin-top: 15px;">
            <a href="estoque.php" class="btn-custom btn-secondary-custom" style="text-decoration: none; text-align: center; line-height: 41px;">Limpar Pesquisa</a>
        </div>
    </div>
</body>
</html>
