<?php
    // 1. Recebemos APENAS o que sempre vem na URL (Ação/Opção e ID)
    $opcao = $_GET['opcao'] ?? null; /* Pode ser 'I' (Insert), 'U' (Update) ou 'D' (Delete) */
    $id = $_GET['id'] ?? null;

    include('funcoes.php');

    $sql = ""; // Inicializa a variável SQL para evitar erros

    // 2. Verificamos qual é a ação ANTES de tentar pegar os dados do formulário ($_POST)
    if ($opcao == 'I' || $opcao == 'U') {
        
        // Só entra aqui e pega esses dados se for CADASTRAR (I) ou ALTERAR (U)
        // Usamos o '?? null' para garantir que se a variável não vier, não exiba aquele Warning chato
        $cliente = $_POST['nCliente'] ?? null;
        $marca   = $_POST['nMarca'] ?? null;
        $modelo  = $_POST['nModelo'] ?? null;
        $imei    = $_POST['nImei'] ?? null;

        // Trata o checkbox nAtivo
        $nAtivo = $_POST['nAtivo'] ?? '';
        if ($nAtivo == 'on') {
            $ativo = 'S';
        } else {
            $ativo = 'N';
        }

        if ($opcao == 'I') {
            // --- MODO INSERIR (I) ---
            $id = proximoID('aparelho', 'idAparelho');

            $sql = "INSERT INTO aparelho (idAparelho, Cliente_idCliente, Marca_idMarca, Modelo_idModelo, imeiAparelho)
                    VALUES ($id, $cliente, '$marca', '$modelo', '$imei');";

        } elseif ($opcao == 'U') {
            // --- MODO ATUALIZAR/EDITAR (U) ---
            $sql = "UPDATE aparelho SET 
                        Cliente_idCliente = '$cliente',
                        Marca_idMarca = '$marca',
                        Modelo_idModelo = '$modelo',
                        imeiAparelho = '$imei'
                    WHERE idAparelho = $id;";
        }

    } elseif ($opcao == 'D') {
        // --- MODO EXCLUIR (D) ---
        // Aqui nós ignoramos o $_POST e SÓ usamos o $id que veio da URL. Zero erros!
        $sql = "DELETE FROM aparelho WHERE idAparelho = $id;";
    }

    // 3. Execução da instrução SQL no banco de dados
    if ($sql != "") {
        include('conexao.php'); // Chama sua conexão com o banco
        
        // Executa o comando SQL
        if (mysqli_query($conn, $sql)) {
            // Se deu tudo certo, redireciona o usuário de volta para a página de aparelhos
            header("Location: ../cadastroAparelho.php");
            exit();
        } else {
            // Se der erro no banco, ele te avisa
            echo "Erro ao executar ação no banco de dados: " . mysqli_error($conn);
        }
        
        mysqli_close($conn); // Fecha a conexão
    } else {
        echo "Nenhuma ação válida informada.";
    }
?>