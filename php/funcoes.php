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

/**
 * Registra logs de ações efetuadas no sistema TechOS.
 * Aceita tanto: registrarLog($conn, 'Ação', 'Descrição') 
 * quanto:       registrarLog('Ação', 'Descrição')
 */
function registrarLog($param1, $param2 = '', $param3 = '', $param4 = null) {
    global $conn;

    // 1. Identifica se o 1º parâmetro é uma conexão válida MySQLi
    if ($param1 instanceof mysqli) {
        $conexao   = $param1;
        $acao      = $param2;
        $descricao = $param3;
        $usuario   = $param4;
    } else {
        $conexao   = $conn;
        $acao      = $param1;
        $descricao = $param2;
        $usuario   = $param3;
    }

    // 2. Se a conexão for nula, inclui o conexao.php usando o caminho absoluto correto (__DIR__)
    if (!$conexao) {
        $caminhoConexao = __DIR__ . '/../includes/conexao.php';
        if (file_exists($caminhoConexao)) {
            include_once($caminhoConexao);
            $conexao = $conn; // Pega a variável $conn gerada pelo conexao.php
        }
    }

    // 3. Trava de segurança: se mesmo assim não conectar, cancela para não dar Fatal Error
    if (!$conexao) {
        return false; 
    }

    // 4. Captura do usuário logado via Sessão
    if (empty($usuario)) {
        if (session_status() === PHP_SESSION_NONE) {
            @session_start();
        }
        $usuario = $_SESSION['usuario_nome'] ?? $_SESSION['usuario'] ?? 'Sistema';
    }

    // 5. Captura do IP do cliente
    $ip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';

    // 6. Grava no banco de dados
    $sql = "INSERT INTO logs (usuario, acao, descricao, dataHora, ip) VALUES (?, ?, ?, NOW(), ?)";
    $stmt = mysqli_prepare($conexao, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ssss", $usuario, $acao, $descricao, $ip);
        $sucesso = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        return $sucesso;
    }

    return false;
}

?>
