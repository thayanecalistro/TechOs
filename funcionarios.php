<?php
// include("php/funcoes_funcionarios.php"); // Descomente quando criar o arquivo de funções
$currentPage = 'funcionario';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechOS - Cadastro de Funcionários</title>
    <link rel="stylesheet" href="css/style_funcionarios.css">
</head>
<body>
   
    <?php include('sidebar.php'); ?>

    <div class="page-content">
        
        <div class="funcionario-header">
            <h2>Funcionários</h2>
            <button id="botaoAbrir" class="btn-sucesso">Novo Funcionário</button>
        </div>

        <div class="table-section">        
            
            <fieldset class="search-fieldset">
                <legend>Pesquisar Funcionário</legend>
                <div class="search-box">
                    <input type="text" id="pesquisar" name="pesquisar" placeholder="ID, Nome ou Cargo...">
                    <button type="button" class="btn btn-blue" id="btnBuscar">Buscar</button>
                    <select id="ordenarSelect" class="btn btn-cyan">
                        <option value="" style="color: black;">Ordenar</option>
                        <option value="id" style="color: black;">ID</option>
                        <option value="nome" style="color: black;">Nome</option>
                        <option value="cargo" style="color: black;">Cargo</option>
                    </select>
                </div>
            </fieldset>
            
            <div class="table-card-fundo">
                <div class="table-container"> 
                    <table class="funcionario-table">
                        <thead>
                            <tr>
                                <th scope="col" style="width: 8%;">ID</th>
                                <th scope="col" style="width: 15%;">Foto</th>
                                <th scope="col" style="width: 32%;">Nome do Funcionário</th>
                                <th scope="col" style="width: 20%;">Cargo/Tipo</th>
                                <th scope="col" style="width: 15%;">Contato</th>
                                <th scope="col" style="width: 10%; text-align: center;">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>#1</td>
                                <td><div class="user-avatar-blank"></div></td>
                                <td>Thay</td>
                                <td>Administrador</td>
                                <td>(47) 99999-0000</td>
                                <td style="text-align: center;">[Editar]</td>
                            </tr>
                            <?php 
                                // echo listaFuncionarios(); 
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div id="meuModal" class="modal">
            <div class="modal-conteudo">
                <span class="botaoFechar">&times;</span>
                <h2>Cadastro de Funcionário</h2>
                <hr style="border: 1px solid #334e68; margin-bottom: 20px;">

                <form method="POST" action="php/salvarFuncionario.php?opcao=I" enctype="multipart/form-data">
                    
                    <div class="linhaFormulario">
                        <div class="input-grupo">
                            <label class="form-label">Nome Completo:</label>
                            <input type="text" placeholder="Nome do funcionário" name="nNome" required>
                        </div>
                        <div class="input-grupo">
                            <label class="form-label">CPF:</label>
                            <input type="text" placeholder="000.000.000-00" name="nCpf">
                        </div>
                    </div>

                    <div class="linhaFormulario">
                        <div class="input-grupo">
                            <label class="form-label">Cargo / Perfil de Acesso:</label>
                            <select name="nTipo" class="form-select" required>
                                <option value="">Selecione...</option>
                                <option value="Administrador">Administrador</option>
                                <option value="Tecnico">Técnico</option>
                                <option value="Atendente">Atendente</option>
                            </select>
                        </div>
                        <div class="input-grupo">
                            <label class="form-label">Telefone / Celular:</label>
                            <input type="text" placeholder="(00) 00000-0000" name="nTelefone">
                        </div>
                    </div>

                    <div class="linhaFormulario">
                        <div class="input-grupo">
                            <label class="form-label">E-mail para contato:</label>
                            <input type="email" placeholder="email@empresa.com" name="nEmail">
                        </div>
                    </div>

                    <div class="linhaFormulario">
                        <div class="input-grupo">
                            <label class="form-label">Endereço Residencial:</label>
                            <input type="text" placeholder="Rua, número, bairro..." name="nEndereco">
                        </div>
                    </div>

                    <h3 style="color: #62b6cb; margin: 15px 0 5px 0; font-size: 1.1rem;">Credenciais de Acesso</h3>

                    <div class="linhaFormulario">
                        <div class="input-grupo">
                            <label class="form-label">Usuário (Login):</label>
                            <input type="text" placeholder="usuario.login" name="nLogin" required>
                        </div>
                        <div class="input-grupo">
                            <label class="form-label">Senha:</label>
                            <input type="password" placeholder="******" name="nSenha" required>
                        </div>
                    </div>

                    <div class="linhaFormulario" style="margin-top: 10px;">
                        <div class="input-grupo">
                            <label class="form-label">Foto de Perfil:</label>
                            <input type="file" name="nFoto" accept="image/*" style="padding: 5px;">
                        </div>
                    </div>

                    <div class="botaoContainer"> 
                        <input type="submit" value="Salvar Funcionário" id="botaoSalvar">
                    </div>
                </form>
            </div>
        </div>

    </div>

    <script src="js/funcionario.js"></script>
</body>
</html>