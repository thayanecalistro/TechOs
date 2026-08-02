<?php
 include('funcaoCliente.php');
 include('funcaoAparelho.php');
 include ('funcaoFuncionario.php'); 
 include ('funcaoOrcamento.php');
 include_once("funcaoEstoque.php");
 include ('funcaoOs.php');

function listaAparelhosGeral(){
    $html = "";

    // SQL com INNER JOIN usando as chaves estrangeiras exatas das suas imagens
    $sql = "SELECT a.idAparelho, c.nomeCliente, m.nomeMarca, a.Modelo_idModelo, a.imeiAparelho, a.historicoAparelho 
            FROM aparelho a
            INNER JOIN clientes c ON a.Cliente_idCliente = c.idCliente
            INNER JOIN marca m ON a.Marca_idMarca = m.idMarca
            ORDER BY a.idAparelho DESC";

    include("includes/conexao.php");
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
?>