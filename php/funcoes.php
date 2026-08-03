<?php
// Usando include_once para evitar que qualquer arquivo seja lido 2 vezes
include_once('funcaoCliente.php');
include_once('funcaoAparelho.php');
include_once('funcaoFuncionario.php'); 
include_once('funcaoOrcamento.php');
include_once('funcaoEstoque.php');
include_once('funcaoOs.php');

// Função auxiliar para resolver a conexão independentemente de onde o arquivo é chamado
if (!function_exists('obterConexao')) {
    function obterConexao() {
        if (file_exists("includes/conexao.php")) {
            include("includes/conexao.php");
        } elseif (file_exists("../includes/conexao.php")) {
            include("../includes/conexao.php");
        } else {
            include(__DIR__ . "/../includes/conexao.php");
        }
        return $conn ?? null;
    }
}

function foto($id = null) {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $caminhoPadrao = "img/usuarios/padrao.png";
    $nomeFoto = "";

    // 1. Tenta pegar a foto da Session se for o usuário logado
    if ($id === null || (isset($_SESSION['idFuncionario']) && $_SESSION['idFuncionario'] == $id)) {
        if (!empty($_SESSION['fotoFuncionario'])) {
            $nomeFoto = $_SESSION['fotoFuncionario'];
        }
    }

    // 2. Se não encontrou na Session e temos um ID, busca no banco de dados
    if (empty($nomeFoto) && !empty($id)) {
        include("includes/conexao.php");
        if (isset($conn)) {
            $idLimpo = mysqli_real_escape_string($conn, $id);
            $query = "SELECT fotoFuncionario FROM funcionario WHERE idFuncionario = '$idLimpo' LIMIT 1";
            $res = mysqli_query($conn, $query);
            if ($res && $row = mysqli_fetch_assoc($res)) {
                $nomeFoto = $row['fotoFuncionario'];
            }
        }
    }

    // 3. Monta o caminho e valida se o arquivo existe na pasta
    if (!empty($nomeFoto)) {
        $caminhoFoto = "img/usuarios/" . $nomeFoto;
        if (file_exists($caminhoFoto)) {
            return $caminhoFoto . "?v=" . time(); // Previne cache do navegador
        }
    }

    return $caminhoPadrao;
}

function nomeFuncionario($id = null) {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    return $_SESSION['nomeFuncionario'] ?? "Colaborador";
}

function registrarLog($acao, $descricao, $idFuncionario = null) {
    include("includes/conexao.php");
    
    // Garante que a sessão esteja iniciada para ler a variável $_SESSION
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    $usuario = $_SESSION['nomeFuncionario'] ?? 'Sistema';
    if (!$idFuncionario && isset($_SESSION['idFuncionario'])) {
        $idFuncionario = $_SESSION['idFuncionario'];
    }

    $stmt = $conn->prepare("INSERT INTO logs_sistema (usuarioLog, Funcionario_idFuncionario, acaoLog, descricaoLog) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("siss", $usuario, $idFuncionario, $acao, $descricao);
    $stmt->execute();
    $stmt->close();
    mysqli_close($conn);
}
?>
