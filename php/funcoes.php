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

if (!function_exists('listaAparelhosGeral')) {
    function listaAparelhosGeral(){
        $html = "";
        $conn = obterConexao();

        if (!$conn) return "<tr><td colspan='6'>Erro de conexão com o banco.</td></tr>";

        $sql = "SELECT a.idAparelho, c.nomeCliente, m.nomeMarca, a.Modelo_idModelo, a.imeiAparelho, a.historicoAparelho 
                FROM aparelho a
                INNER JOIN clientes c ON a.Cliente_idCliente = c.idCliente
                INNER JOIN marca m ON a.Marca_idMarca = m.idMarca
                ORDER BY a.idAparelho DESC";

        $result = mysqli_query($conn, $sql);
        mysqli_close($conn);

        if($result && mysqli_num_rows($result) > 0){
            foreach($result as $coluna){
                $html .= "<tr>
                            <td>#".$coluna['idAparelho']."</td>
                            <td>".$coluna['nomeCliente']."</td>
                            <td>".$coluna['nomeMarca']."</td>
                            <td>ID: ".$coluna['Modelo_idModelo']."</td>
                            <td>".$coluna['imeiAparelho']."</td>
                            <td>".htmlspecialchars($coluna['historicoAparelho'])."</td>
                        </tr>";
            }
        } else {
            $html .= "<tr><td colspan='6' style='text-align:center;'>Nenhum aparelho cadastrado no momento.</td></tr>";
        }
        return $html;
    }
}

if (!function_exists('foto')) {
    function foto($idFuncionario = null) {
        $fotoPadrao = "img/avatar_default.png";
        if (!$idFuncionario) return $fotoPadrao;

        $conn = obterConexao();
        if (!$conn) return $fotoPadrao;

        $sql = "SELECT foto FROM funcionario WHERE idFuncionario = " . intval($idFuncionario);
        $result = mysqli_query($conn, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            $dados = mysqli_fetch_assoc($result);
            mysqli_close($conn);
            
            if (!empty($dados['foto'])) {
                return $dados['foto'];
            }
        } else {
            mysqli_close($conn);
        }

        return $fotoPadrao;
    }
}

if (!function_exists('nomeFuncionario')) {
    function nomeFuncionario($idFuncionario = null) {
        if (!$idFuncionario) return "Usuário";

        $conn = obterConexao();
        if (!$conn) return "Usuário";

        $sql = "SELECT nomeFuncionario FROM funcionario WHERE idFuncionario = " . intval($idFuncionario);
        $result = mysqli_query($conn, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            $dados = mysqli_fetch_assoc($result);
            mysqli_close($conn);
            return htmlspecialchars($dados['nomeFuncionario'], ENT_QUOTES, 'UTF-8');
        }

        mysqli_close($conn);
        return "Usuário";
    }
}
?>
