<?php
<<<<<<< Updated upstream

include("php/funcoes.php");
$currentPage = 'cliente';

=======
// Removido include fictício para fins de exibição limpa. Mantenha se necessário.
include("php/funcoes.php");

$currentPage = 'cliente';

// Simulação de dados para visualização estruturada no padrão TechOS
$clientes_mock = [
    ["id" => 1, "nome" => "João Silva", "contato" => "(47) 99999-1111"],
    ["id" => 2, "nome" => "Luana Souza", "contato" => "(47) 98888-2222"],
    ["id" => 3, "nome" => "Vitor Santos", "contato" => "(47) 97777-3333"]
];
>>>>>>> Stashed changes
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechOS - Cadastro de Clientes</title>
<<<<<<< Updated upstream

    <link rel="stylesheet" href="css/os.css"> 
    <link rel="stylesheet" href="css/style_cliente.css"> 
=======
    
    <link rel="stylesheet" href="css/os.css">
    <link rel="stylesheet" href="css/formularios.css">
>>>>>>> Stashed changes
</head>
<body>

    <?php include('sidebar.php'); ?>

    <div class="page-content">
        
        <div class="os-header">
            <div>
<<<<<<< Updated upstream
                <h2>Gerenciar Clientes</h2>
            </div>
            <button type="submit" class="btn btn-sucesso" id="botaoAbrir">+ Novo</button>
        </div>

        <fieldset class="search-fieldset">
            <legend>Pesquisar</legend>
            <div class="search-box">
                <input type="text" id="pesquisar" name="pesquisar" placeholder="ID ou Diagnóstico...">
                <button type="button" class="btn btn-blue" id="btnBuscar">Buscar</button>
                <select id="ordenarSelect" class="btn btn-cyan" style="color: #102a43; cursor: pointer; height: 31px; padding: 0 10px;">
                    <option value="" style="color: black;">Ordenar</option>
                    <option value="id" style="color: black;">ID</option>
                    <option value="status" style="color: black;">Status</option>
                </select>
=======
                <h2>Gerenciamento de Clientes</h2>
            </div>
            <button type="button" class="btn btn-cyan" id="botaoAbrir">+ Novo Cliente</button>
        </div>

        <fieldset class="search-fieldset">
            <legend>Pesquisar Cliente</legend>
            <div class="search-box">
                <input type="text" id="pesquisar" name="pesquisar" placeholder="ID ou Nome do Cliente...">
                <button type="button" class="btn btn-blue" id="btnBuscar">Buscar</button>
>>>>>>> Stashed changes
            </div>
        </fieldset>

        <div class="section-card">
<<<<<<< Updated upstream

            <div class="table-container">
                <table class="os-table" id="orcamentoTable">
=======
            <h3>Clientes Cadastrados</h3>

            <div class="table-container">
                <table class="os-table" id="clienteTable">
>>>>>>> Stashed changes
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome do Cliente</th>
                            <th>Contato</th>
<<<<<<< Updated upstream
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php echo listaClientes(); ?>
=======
                            <th style="text-align: center; width: 120px;">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        // Se você usar a função dinâmica original, basta descomentar a linha abaixo:
                        // echo listaClientes(); 
                        
                        // Renderização base do mock padronizado:
                        foreach ($clientes_mock as $cliente): ?>
                            <tr>
                                <td><?= $cliente['id']; ?></td>
                                <td><?= $cliente['nome']; ?></td>
                                <td><?= $cliente['contato']; ?></td>
                                <td style="text-align: center;">
                                    <button type="button" class="btn btn-blue" style="padding: 3px 10px; font-size: 12px;" onclick="abrirModalAlterar(<?= $cliente['id']; ?>)">Editar</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
>>>>>>> Stashed changes
                    </tbody>
                </table>
            </div>
        </div>
    </div>

<<<<<<< Updated upstream
    <!--                   TELA DE CADASTRO                                 -->
    <div id="meuModal" class="modal">
        <div class="modal-conteudo">
            <span class="botaoFechar">&times;</span>
            <h2>Cadastro de Clientes</h2>

            <form method="POST" action="php/salvarCliente.php?opcao=I">

            <div class="linhaFormulario">
                <input type="text" placeholder="Nome do cliente" name="nNome">

                <input type="text" placeholder="CPF" name="nCpf">
            </div>

            <div class="linhaFormulario">
                <input type="text" placeholder="Telefone" name="nTelefone">
            </div>

                <h3>Endereço</h3>

            <div class="linhaFormulario">
                <input type="text" placeholder="CEP" name="nCep">
                <input type="text" placeholder="Endereço" name="nEndereco">
            </div>

            <div class="linhaFormulario">
                <input type="text" placeholder="Número" name="nNumero">
                <input type="text" placeholder="Complemento" name="nComplemento">
            </div>

            <div class="linhaFormulario">
            <input type="text" placeholder="Bairro" name="nBairro">
                <input type="text" placeholder="Cidade" name="nCidade">
            </div>

            <div class="linhaFormulario">
                <input type="text" placeholder="Estado" name="nEstado">                     
            </div>

            <div class="botaoContainer"> <input type="submit" value="Salvar" id="botaoSalvar" ></div>

=======
    <div id="meuModal" class="modal-overlay">
        <div class="modal-content modal-large">
            <h3>Cadastro de Novo Cliente</h3>
            <form method="POST" action="php/salvarCliente.php?opcao=I" id="formCadastroCliente">
                <div class="form-grid">
                    <div class="form-group">
                        <label for="nNome">Nome do Cliente *</label>
                        <input type="text" id="nNome" name="nNome" required placeholder="Nome completo">
                    </div>

                    <div class="form-group">
                        <label for="nCpf">CPF</label>
                        <input type="text" id="nCpf" name="nCpf" placeholder="000.000.000-00">
                    </div>

                    <div class="form-group full-width">
                        <label for="nTelefone">Telefone / WhatsApp *</label>
                        <input type="text" id="nTelefone" name="nTelefone" required placeholder="(00) 00000-0000">
                    </div>

                    <div class="form-section-title">Endereço residencial</div>

                    <div class="form-group">
                        <label for="nCep">CEP</label>
                        <input type="text" id="nCep" name="nCep" placeholder="00000-000">
                    </div>

                    <div class="form-group">
                        <label for="nEndereco">Logradouro (Rua/Av)</label>
                        <input type="text" id="nEndereco" name="nEndereco" placeholder="Ex: Rua das Flores">
                    </div>

                    <div class="form-group">
                        <label for="nNumero">Número</label>
                        <input type="text" id="nNumero" name="nNumero" placeholder="Nº">
                    </div>

                    <div class="form-group">
                        <label for="nComplemento">Complemento</label>
                        <input type="text" id="nComplemento" name="nComplemento" placeholder="Apt, Bloco...">
                    </div>

                    <div class="form-group">
                        <label for="nBairro">Bairro</label>
                        <input type="text" id="nBairro" name="nBairro" placeholder="Bairro">
                    </div>

                    <div class="form-group">
                        <label for="nCidade">Cidade</label>
                        <input type="text" id="nCidade" name="nCidade" placeholder="Cidade">
                    </div>

                    <div class="form-group full-width">
                        <label for="nEstado">Estado (UF)</label>
                        <input type="text" id="nEstado" name="nEstado" placeholder="Ex: SC">
                    </div>
                </div>

                <div class="modal-buttons">
                    <button type="submit" class="btn btn-cyan">Salvar</button>
                    <button type="button" class="btn btn-red" id="botaoFechar">Cancelar</button>
                </div>
>>>>>>> Stashed changes
            </form>
        </div>
    </div>

<<<<<<< Updated upstream
    <!--         MODAL PARA ALTERAÇÃO DE DADOS DO COLABORADOR -->
    <div id="meuModalAlterar" class="modal">
        <div class="modal-conteudo">
            <span class="botaoFecharAlterar">&times;</span>
            <h2>Cadastro de Clientes</h2>

            <form method="POST" action="php/salvarCliente.php?opcao=I">
            
                <input type="hidden" id="alterarId" name="nIdCliente">

                <div class="linhaFormulario">
                    <input type="text" placeholder="Nome do cliente" name="nNome">

                    <input type="text" placeholder="CPF" name="nCpf">
                </div>

                <div class="linhaFormulario">
                    <input type="text" placeholder="Telefone" name="nTelefone">
                </div>

                    <h3>Endereço</h3>

                <div class="linhaFormulario">
                    <input type="text" placeholder="CEP" name="nCep">
                    <input type="text" placeholder="Endereço" name="nEndereco">
                </div>

                <div class="linhaFormulario">
                    <input type="text" placeholder="Número" name="nNumero">
                    <input type="text" placeholder="Complemento" name="nComplemento">
                </div>

                <div class="linhaFormulario">
                <input type="text" placeholder="Bairro" name="nBairro">
                    <input type="text" placeholder="Cidade" name="nCidade">
                </div>

                <div class="linhaFormulario">
                    <input type="text" placeholder="Estado" name="nEstado">                     
                </div>

                <div class="botaoContainer"> <input type="submit" value="Salvar" id="botaoSalvar" ></div>

            </form>

        </div>
    </div>

    <script src="js/scriptCadastro.js"></script>
=======
    <div id="meuModalAlterar" class="modal-overlay">
        <div class="modal-content modal-large">
            <h3>Alterar Dados do Cliente</h3>
            <form method="POST" action="php/salvarCliente.php?opcao=A" id="formAlterarCliente">
                <input type="hidden" id="alterarId" name="nIdCliente">

                <div class="form-grid">
                    <div class="form-group">
                        <label for="altNome">Nome do Cliente *</label>
                        <input type="text" id="altNome" name="nNome" required>
                    </div>

                    <div class="form-group">
                        <label for="altCpf">CPF</label>
                        <input type="text" id="altCpf" name="nCpf">
                    </div>

                    <div class="form-group full-width">
                        <label for="altTelefone">Telefone / WhatsApp *</label>
                        <input type="text" id="altTelefone" name="nTelefone" required>
                    </div>

                    <div class="form-section-title">Endereço residencial</div>

                    <div class="form-group">
                        <label for="altCep">CEP</label>
                        <input type="text" id="altCep" name="nCep">
                    </div>

                    <div class="form-group">
                        <label for="altEndereco">Logradouro (Rua/Av)</label>
                        <input type="text" id="altEndereco" name="nEndereco">
                    </div>

                    <div class="form-group">
                        <label for="altNumero">Número</label>
                        <input type="text" id="altNumero" name="nNumero">
                    </div>

                    <div class="form-group">
                        <label for="altComplemento">Complemento</label>
                        <input type="text" id="altComplemento" name="nComplemento">
                    </div>

                    <div class="form-group">
                        <label for="altBairro">Bairro</label>
                        <input type="text" id="altBairro" name="nBairro">
                    </div>

                    <div class="form-group">
                        <label for="altCidade">Cidade</label>
                        <input type="text" id="altCidade" name="nCidade">
                    </div>

                    <div class="form-group full-width">
                        <label for="altEstado">Estado (UF)</label>
                        <input type="text" id="altEstado" name="nEstado">
                    </div>
                </div>

                <div class="modal-buttons">
                    <button type="submit" class="btn btn-cyan">Atualizar</button>
                    <button type="button" class="btn btn-red" id="botaoFecharAlterar">Cancelar</button>
                </div>
            </form>
        </div>
    </div>

    <script src="js/clientes.js"></script>
>>>>>>> Stashed changes
</body>
</html>