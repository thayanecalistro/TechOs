<?php

// 1. Arrays vazios (Corrigido)
$clientes = [];
$marcas   = [];

// 2. Chama o seu arquivo de conexão
require_once('php/conexao.php');

// 3. Busca os Clientes
$resultadoClientes = mysqli_query($conn, "SELECT idCliente, nomeCliente FROM cliente ORDER BY nomeCliente ASC");
if ($resultadoClientes) {
    while ($linha = mysqli_fetch_assoc($resultadoClientes)) {
        $clientes[] = $linha;
    }
}

// 4. Busca as Marcas
$resultadoMarcas = mysqli_query($conn, "SELECT idMarca, nomeMarca FROM marca ORDER BY nomeMarca ASC");
if ($resultadoMarcas) {
    while ($linha = mysqli_fetch_assoc($resultadoMarcas)) {
        $marcas[] = $linha;
    }
}
    
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Aparelhos</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
         
    <style>
        /* Estilos baseados na imagem enviada */
        body {
            background-color: #2c3e50; /* Fundo azul escuro */
            color: #ecf0f1; /* Texto claro */
            font-family: Arial, sans-serif;
            height: 100vh;
            display: flex;
            align-items: flex-start;
            justify-content: center;
            padding-top: 50px;
        }

        .form-container {
            width: 100%;
            max-width: 600px;
        }

        /* Título com fonte serifada semelhante à imagem */
        h2 {
            font-family: "Georgia", serif;
            text-align: center;
            margin-bottom: 40px;
            font-weight: normal;
            font-size: 2.2rem;
        }

        /* Labels alinhadas à direita */
        .form-label {
            text-align: right;
            padding-top: 7px;
            font-size: 0.95rem;
        }

        /* Estilizando os inputs e selects para ficarem escuros */
        .form-control, .form-select {
            background-color: #34495e; 
            border: 1px solid #5d6d7e;
            color: #ecf0f1;
            border-radius: 4px;
        }

        /* Efeito ao clicar no input (Focus) */
        .form-control:focus, .form-select:focus {
            background-color: #2c3e50;
            color: #ecf0f1;
            border-color: #3498db;
            box-shadow: 0 0 0 0.25rem rgba(52, 152, 219, 0.25);
        }

        /* Ajuste de cor nos placeholders e opções do select */
        .form-control::placeholder { color: #95a5a6; }
        option { background-color: #34495e; color: #ecf0f1; }

        /* Botões customizados para bater com as cores da imagem */
        .botoes-acao {
            display: flex;
            justify-content: center;
            gap: 10px; /* Espaço entre os botões */
            margin-top: 30px;
        }

        .btn-custom { color: white !important; border: none; border-radius: 3px;}
        .btn-cadastrar { background-color: #5cb85c; }
        .btn-pesquisar { background-color: #5bc0de; }
        .btn-alterar   { background-color: #f0ad4e; }
        .btn-excluir   { background-color: #d9534f; }
        
        .btn-custom:hover { opacity: 0.9; }
    </style>
</head>

<body>

    <div class="form-container">
        <h2>Cadastro de Aparelhos</h2>
        
        <form method="POST" action="">

            <div class="row mb-3">
                <label for="cliente_id" class="col-sm-3 col-form-label">Cliente:</label>
                <div class="col-sm-9">
                    <select class="form-select" id="cliente_id" name="cliente_id">
                        <option value=""></option>
                        <?php foreach($clientes as $cliente): ?>
                            <option value="<?= $cliente['idCliente'] ?>">
                                <?= htmlspecialchars($cliente['nomeCliente']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <label for="marca_id" class="col-sm-3 col-form-label">Marca:</label>
                <div class="col-sm-9">
                    <select class="form-select" id="marca_id" name="marca_id">
                        <option value=""></option>
                        <?php foreach($marcas as $marca): ?>
                            <option value="<?= $marca['idMarca'] ?>">
                                <?= htmlspecialchars($marca['nomeMarca']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <label for="modelo" class="col-sm-3 col-form-label">Modelo:</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="modelo" name="modelo">
                </div>
            </div>

            <div class="row mb-3">
                <label for="historico" class="col-sm-3 col-form-label">Histórico:</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="historico" name="historico">
                </div>
            </div>

            <div class="row mb-3">
                <label for="imei" class="col-sm-3 col-form-label">IMEI:</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="imei" name="imei">
                </div>
            </div>

            <div class="botoes-acao">
                <button type="submit" name="acao" value="cadastrar" class="btn btn-custom btn-cadastrar px-3">Cadastrar</button>
                <button type="submit" name="acao" value="pesquisar" class="btn btn-custom btn-pesquisar px-3">Pesquisar</button>
                <button type="submit" name="acao" value="alterar"   class="btn btn-custom btn-alterar px-3">Alterar</button>
                <button type="submit" name="acao" value="excluir"   class="btn btn-custom btn-excluir px-3">Excluir</button>
            </div>

        </form>
    </div>

</body>
</html>