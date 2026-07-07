<?php

function listarOS() {
    $html = "";

    // INNER JOIN idêntico ao do orçamento, mas focado na tabela ordem_servico
    $sql = "SELECT os.idOS, 
                   os.aberturaOS, 
                   os.fechamentoOS, 
                   os.valorOS, 
                   os.status,
                   c.nomeCliente, 
                   m.nomeMarca, 
                   mo.nomeModelo
            FROM os os
            INNER JOIN clientes c ON os.Cliente_idCliente = c.idCliente
            INNER JOIN aparelho a ON os.Aparelho_idAparelho = a.idAparelho
            INNER JOIN modelo mo ON a.Modelo_idModelo = mo.idModelo
            INNER JOIN marca m ON mo.Marca_idMarca = m.idMarca
            ORDER BY os.idOS DESC";

    // Inclui a conexão igualzinho à função de orçamentos
    include("conexao.php");
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        foreach ($result as $coluna) {
            // Formatação do Status e as Badges visuais das OSs
            $statusFormatado = ucfirst($coluna['status']);
            $classeBadge = 'badge-aberto'; 
            if (strtolower($coluna['status']) == 'aprovado' || strtolower($coluna['status']) == 'em andamento') $classeBadge = 'badge-aprovado';
            if (strtolower($coluna['status']) == 'finalizado' || strtolower($coluna['status']) == 'concluido') $classeBadge = 'badge-sucesso';
            if (strtolower($coluna['status']) == 'cancelado') $classeBadge = 'badge-danger';

            // Formatação amigável das datas de Abertura e Fechamento
            $abertura = !empty($coluna['aberturaOS']) ? date('d/m/Y H:i', strtotime($coluna['aberturaOS'])) : "---";
            $fechamento = (!empty($coluna['fechamentoOS']) && $coluna['fechamentoOS'] != '0000-00-00 00:00:00') 
                ? date('d/m/Y H:i', strtotime($coluna['fechamentoOS'])) 
                : "---";

            // Monta a linha seguindo o cabeçalho exato do seu arquivo Os.php
            $html .= "<tr>
                        <td>" . $coluna['idOS'] . "</td>
                        <td>" . $abertura . "</td>
                        <td>" . $fechamento . "</td>
                        <td>" . htmlspecialchars($coluna['nomeCliente'], ENT_QUOTES) . "</td>
                        <td>" . htmlspecialchars($coluna['nomeMarca'] . " " . $coluna['nomeModelo'], ENT_QUOTES) . "</td>
                        <td><strong>R$ " . number_format($coluna['valorOS'], 2, ',', '.') . "</strong></td>
                        <td><span class='badge " . $classeBadge . "'>" . $statusFormatado . "</span></td>
                      </tr>";
        }
    } else {
        // Colspan ajustado para 7 colunas (ID, Abertura, Fechamento, Cliente, Aparelho, Valor, Status)
        $html .= "<tr><td colspan='7' style='text-align:center;'>Nenhuma ordem de serviço cadastrada.</td></tr>";
    }

    mysqli_close($conn);
    return $html;
}

?>