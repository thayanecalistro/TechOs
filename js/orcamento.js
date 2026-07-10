document.addEventListener("DOMContentLoaded", function () {
    const modal = document.getElementById("cadastroModal");
    const btnNovo = document.getElementById("btnNovoOrcamento");
    const btnFechar = document.getElementById("btnFecharModal");
    const statusModal = document.getElementById("statusModal");
    const btnFecharStatusModal = document.getElementById("btnFecharStatusModal");
    
    const containerPecas = document.getElementById("container-pecas");
    const btnAdicionarPeca = document.getElementById("btnAdicionarPeca");
    const inputMaoObra = document.getElementById("maoObra");
    const inputValorTotal = document.getElementById("valorTotal");

    if (btnNovo) {
        btnNovo.addEventListener("click", function() {
            // Restaura o título original e o action de cadastro
            if (cadastroModal) {
                const tituloModal = cadastroModal.querySelector("h3");
                if (tituloModal) tituloModal.innerText = "Cadastrar Novo Orçamento";
            }
            const formOrcamento = document.getElementById("formOrcamento");
            if (formOrcamento) formOrcamento.action = "php/salvarOrcamento.php"; // Seu arquivo original de cadastro

            // LIBERA os campos novamente para quando for um novo cadastro
            const inputCliente = document.getElementById("cliente_busca") || document.getElementById("nCliente");
            if (inputCliente) {
                inputCliente.readOnly = false;
                inputCliente.style.backgroundColor = "";
            }

            const selectAparelho = document.getElementById("Aparelho_idAparelho") || document.getElementById("nAparelho");
            if (selectAparelho) {
                selectAparelho.style.pointerEvents = "";
                selectAparelho.style.backgroundColor = "";
            }
        });
    }

    if (btnNovo) {
        btnNovo.addEventListener("click", () => modal.style.display = "flex");
    }

    if (btnFecharStatusModal) {
        btnFecharStatusModal.addEventListener("click", function(){
            statusModal.style.display = "none";
        });
    }

    window.addEventListener("click", function(e) {
        if (e.target === statusModal){
            statusModal.style.display = "none";
        }
    });

    const fecharEResetarModal = () => {
        if (modal) modal.style.display = "none";
        const form = document.getElementById("formOrcamento");
        if (form) form.reset();
        if (containerPecas) {
            containerPecas.innerHTML = `
                <div class="peca-row" style="display: flex; gap: 10px; margin-bottom: 10px;">
                    <input type="text" name="nPeca[]" class="classe-busca-peca" list="listaPecasEstoque" placeholder="Busque a peça no estoque..." style="flex: 2;" required autocomplete="off">
                    <input type="hidden" name="nIdEstoque[]" class="classe-id-estoque">
                    <input type="number" name="nValorUni[]" class="classe-val-uni" step="0.01" value="0.00" style="flex: 1;" readonly>
                    <input type="number" name="nQtd[]" class="classe-qtd" value="1" min="1" style="width: 70px;">
                </div>
            `;
        }
        if (inputValorTotal) inputValorTotal.value = "0.00";
    };

    if (btnFechar) btnFechar.addEventListener("click", fecharEResetarModal);
    window.addEventListener("click", (e) => { if (e.target === modal) fecharEResetarModal(); });

    if (btnAdicionarPeca) {
        btnAdicionarPeca.addEventListener("click", function () {
            const novaLinha = document.createElement("div");
            novaLinha.className = "peca-row";
            novaLinha.style = "display: flex; gap: 10px; margin-bottom: 10px;";
            novaLinha.innerHTML = `
                <input type="text" name="nPeca[]" class="classe-busca-peca" list="listaPecasEstoque" placeholder="Busque a peça no estoque..." style="flex: 2;" required autocomplete="off">
                <input type="hidden" name="nIdEstoque[]" class="classe-id-estoque">
                <input type="number" name="nValorUni[]" class="classe-val-uni" step="0.01" value="0.00" style="flex: 1;" readonly>
                <input type="number" name="nQtd[]" class="classe-qtd" value="1" min="1" style="width: 70px;">
                <button type="button" class="btn btn-red btn-remover-linha" style="padding: 0 10px; height: 35px;">X</button>
            `;
            containerPecas.appendChild(novaLinha);
        });
    }

    if (containerPecas) {
        containerPecas.addEventListener("input", function (e) {
            if (e.target.classList.contains("classe-busca-peca")) {
                const inputBusca = e.target;
                const linha = inputBusca.closest(".peca-row");
                const datalist = document.getElementById("listaPecasEstoque");
                
                const opcao = Array.from(datalist.options).find(o => o.value === inputBusca.value);
                
                if (opcao) {
                    linha.querySelector(".classe-id-estoque").value = opcao.getAttribute("data-id");
                    linha.querySelector(".classe-val-uni").value = parseFloat(opcao.getAttribute("data-valor")).toFixed(2);
                } else {
                    linha.querySelector(".classe-id-estoque").value = "";
                    linha.querySelector(".classe-val-uni").value = "0.00";
                }
            }
            calcularTotal();
        });

        containerPecas.addEventListener("click", function (e) {
            if (e.target.classList.contains("btn-remover-linha")) {
                e.target.parentElement.remove();
                calcularTotal();
            }
        });
    }

    if (inputMaoObra) {
        inputMaoObra.addEventListener("input", calcularTotal);
        inputMaoObra.addEventListener("keyup", calcularTotal);
        inputMaoObra.addEventListener("change", calcularTotal);
        inputMaoObra.addEventListener("blur", calcularTotal);
    }

    function calcularTotal() {
        let subtotalPecas = 0;
        if (containerPecas) {
            const linhas = containerPecas.querySelectorAll(".peca-row");
            linhas.forEach(linha => {
                const inputVal = linha.querySelector(".classe-val-uni");
                const inputQtd = linha.querySelector(".classe-qtd");
                
                if (inputVal && inputQtd) {
                    let textoVal = inputVal.value.replace(",", ".");
                    const valUni = parseFloat(textoVal) || 0;
                    const qtd = parseInt(inputQtd.value) || 1;
                    subtotalPecas += (valUni * qtd);
                }
            });
        }

        let textoMaoObra = inputMaoObra ? inputMaoObra.value : "0";
        textoMaoObra = textoMaoObra.replace("R$", "").replace(/\s/g, "").replace(",", ".");
        const maoObra = parseFloat(textoMaoObra) || 0;

        if (inputValorTotal) {
            inputValorTotal.value = (subtotalPecas + maoObra).toFixed(2);
        }
    }

    // O AJAX do Cliente agora está dentro do escopo DOMContentLoaded seguro
    const inputClienteBusca = document.getElementById('cliente_busca');
    if (inputClienteBusca) {
        inputClienteBusca.addEventListener('input', function() {
            var inputVisivel = this;
            var inputEscondido = document.getElementById('Cliente_idCliente');
            var datalist = document.getElementById('listaClientes');
            var selectAparelho = document.getElementById('Aparelho_idAparelho');
            
            var opcaoSelecionada = Array.from(datalist.options).find(o => o.value === inputVisivel.value);

            if (opcaoSelecionada) {
                var idCliente = opcaoSelecionada.getAttribute('data-id');
                inputEscondido.value = idCliente;
                selectAparelho.innerHTML = "<option value=''>Carregando aparelhos...</option>";

                fetch('php/buscar_aparelhos.php?cliente_id=' + idCliente)
                    .then(res => res.text())
                    .then(html => { selectAparelho.innerHTML = html; })
                    .catch(() => { selectAparelho.innerHTML = "<option value=''>Erro ao carregar</option>"; });
            } else {
                inputEscondido.value = "";
                selectAparelho.innerHTML = "<option value=''>Selecione primeiro o cliente...</option>";
            }
        });
    }

    // =========================================================================
    // CORREÇÃO E IMPLEMENTAÇÃO DA BUSCA EM TEMPO REAL
    // =========================================================================
    const campoPesquisar = document.getElementById("pesquisar");
    const btnBuscar = document.getElementById("btnBuscar");

    function filtrarTabela() {
        const termo = campoPesquisar.value.toLowerCase().trim();
        const linhasTabela = document.querySelectorAll("#orcamentoTable tbody tr");

        linhasTabela.forEach(linha => {
            // Ignora linhas que sejam de "Nenhum orçamento cadastrado"
            if (linha.cells.length < 2) return; 

            // Pega o texto do ID (Coluna 1) e do Cliente (Coluna 2)
            const idTexto = linha.cells[0] ? linha.cells[0].innerText.toLowerCase().trim() : "";
            const clienteTexto = linha.cells[1] ? linha.cells[1].innerText.toLowerCase().trim() : "";
            
            // Se o termo estiver contido no ID ou no Nome do Cliente, exibe a linha
            if (idTexto.includes(termo) || clienteTexto.includes(termo)) {
                linha.style.display = "";
            } else {
                linha.style.display = "none";
            }
        });
    }

    // Filtra tanto ao digitar (tempo real) quanto ao clicar no botão "Buscar"
    if (campoPesquisar) campoPesquisar.addEventListener("input", filtrarTabela);
    if (btnBuscar) btnBuscar.addEventListener("click", filtrarTabela);


    // =========================================================================
    // IMPLEMENTAÇÃO DA ORDENAÇÃO DA TABELA (ID OU STATUS)
    // =========================================================================
    const ordenarSelect = document.getElementById("ordenarSelect");

    if (ordenarSelect) {
        ordenarSelect.addEventListener("change", function () {
            const criterio = this.value; // Pode ser "id", "status" ou ""
            if (!criterio) return;

            const tabelaCorpo = document.querySelector("#orcamentoTable tbody");
            const linhas = Array.from(tabelaCorpo.querySelectorAll("tr"));

            // Se for a linha de "Nenhum orçamento", não ordena
            if (linhas.length === 1 && linhas[0].cells.length < 2) return;

            linhas.sort((linhaA, linhaB) => {
                let valorA, valorB;

                if (criterio === "id") {
                    // Ordenação por ID (Numérica): Coluna 0
                    valorA = parseInt(linhaA.cells[0].innerText) || 0;
                    valorB = parseInt(linhaB.cells[0].innerText) || 0;
                    return valorA - valorB; // Menor para o maior
                } else if (criterio === "status") {
                    // Ordenação por Status (Texto): Coluna 7
                    // Se for um botão (Aberto), pegamos o textContent. Se for badge, também pega o texto.
                    valorA = linhaA.cells[7].textContent.toLowerCase().trim();
                    valorB = linhaB.cells[7].textContent.toLowerCase().trim();
                    return valorA.localeCompare(valorB); // Ordem alfabética
                }
                return 0;
            });

            // Reatribui as linhas ordenadas de volta para o corpo da tabela
            linhas.forEach(linha => tabelaCorpo.appendChild(linha));
        });
    }

    // =========================================================================
    // EVENTO DE DUPLO CLIQUE PARA VISUALIZAÇÃO DE DETALHES (CORRIGIDO)
    // =========================================================================
    const detalhesModal = document.getElementById("detalhesModal");
    const btnFecharDetalhesModal = document.getElementById("btnFecharDetalhesModal");
    const tabelaCorpo = document.querySelector("#orcamentoTable tbody");

    if (btnFecharDetalhesModal) {
        btnFecharDetalhesModal.addEventListener("click", function() {
            detalhesModal.style.display = "none";
        });
    }

    if (tabelaCorpo) {
        tabelaCorpo.addEventListener("dblclick", function (e) {
            // Captura qualquer tag <tr> onde o duplo clique aconteceu
            const linha = e.target.closest("tr");
            if (!linha) return;

            // Segurança: Se for a linha de "Nenhum orçamento cadastrado", não faz nada
            if (linha.cells.length < 2) return;

            // Extrai as informações dos atributos data-*
            const id = linha.getAttribute("data-id");
            const cliente = linha.getAttribute("data-cliente");
            const aparelho = linha.getAttribute("data-aparelho");
            const diagnostico = linha.getAttribute("data-diagnostico"); // Busca o atributo
            const pecas = linha.getAttribute("data-pecas");
            const maoObra = linha.getAttribute("data-mao-obra");
            const total = linha.getAttribute("data-total");
            const status = linha.getAttribute("data-status");

            // Verifica se o ID existe antes de abrir o modal
            if (!id) return;

            // Alimenta os campos do modal
            document.getElementById("viewIdOrcamento").innerText = "#" + id;
            document.getElementById("viewCliente").value = cliente || "";
            document.getElementById("viewAparelho").value = aparelho || "";
            document.getElementById("viewDiagnostico").value = diagnostico || ""; // Preenche o campo
            document.getElementById("viewPecas").value = pecas || "Sem peças vinculadas";
            document.getElementById("viewMaoObra").value = maoObra ? Number(maoObra).toFixed(2) : "0.00";
            document.getElementById("viewTotal").value = total ? Number(total).toFixed(2) : "0.00";
            document.getElementById("viewStatus").value = status || "";

            // Exibe o modal
            detalhesModal.style.display = "flex";
        });
    }

    // =========================================================================
    // MODAL DE CONFIRMAÇÃO DE EXCLUSÃO PERSONALIZADO
    // =========================================================================
    const btnAcaoExcluir = document.getElementById("btnAcaoExcluir");
    const confirmarExcluirModal = document.getElementById("confirmarExcluirModal");
    const btnCancelarExclusao = document.getElementById("btnCancelarExclusao");
    const btnConfirmarExclusaoDefinitiva = document.getElementById("btnConfirmarExclusaoDefinitiva");

    let idParaExcluir = ""; // Variável temporária para guardar o ID ativo

    if (btnAcaoExcluir) {
        btnAcaoExcluir.addEventListener("click", function () {
            // Pega o ID do orçamento aberto no momento
            const idTexto = document.getElementById("viewIdOrcamento").innerText;
            idParaExcluir = idTexto.replace("#", "").trim();

            if (!idParaExcluir) {
                alert("Erro: ID do orçamento não encontrado.");
                return;
            }

            // Injeta o ID no texto do modal de confirmação
            document.getElementById("textoIdExcluir").innerText = "#" + idParaExcluir;

            // Fecha o modal de detalhes e abre o modal de confirmação vermelho
            detalhesModal.style.display = "none";
            confirmarExcluirModal.style.display = "flex";
        });
    }

    // Ação do botão Cancelar (fecha o modal vermelho e reabre o de detalhes se quiser)
    if (btnCancelarExclusao) {
        btnCancelarExclusao.addEventListener("click", function () {
            confirmarExcluirModal.style.display = "none";
            detalhesModal.style.display = "flex"; // Opcional: traz o usuário de volta aos detalhes
        });
    }

    // Ação do botão "Sim, Excluir" (Confirmação Definitiva)
    if (btnConfirmarExclusaoDefinitiva) {
        btnConfirmarExclusaoDefinitiva.addEventListener("click", function () {
            if (idParaExcluir) {
                // Executa o redirecionamento para sua função PHP através do processador
                window.location.href = "php/processarAcoes.php?acao=excluir&id=" + idParaExcluir;
            }
        });
    }

    // =========================================================================
    // AÇÃO DO BOTÃO EDITAR (PREENCHE TUDO E BLOQUEIA CAMPOS RESTRITOS)
    // =========================================================================
    const btnAcaoEditar = document.getElementById("btnAcaoEditar");
    const cadastroModal = document.getElementById("cadastroModal");

    if (btnAcaoEditar) {
        btnAcaoEditar.addEventListener("click", function () {
            // Encontra a linha original da tabela para pegar os IDs ocultos
            const idTexto = document.getElementById("viewIdOrcamento").innerText;
            const idOrcamento = idTexto.replace("#", "").trim();

            if (!idOrcamento){
                alert("Erro: ID do orçamento não identificado.");
                return;
            }

            let linhaOriginal = null;
            const linhas = document.querySelectorAll("#orcamentoTable tbody tr");
            linhas.forEach(function(row) {
                if (row.getAttribute("data-id") === idOrcamento) {
                    linhaOriginal = row;
                }
            });

            if (!linhaOriginal) {
                console.error("Não foi possível encontrar a linha correspondente ao ID #" + idOrcamento);
                alert("Erro ao carregar dados originais do orçamento.");
                return;
            }

            // Fecha o modal de detalhes visual
            if (detalhesModal) detalhesModal.style.display = "none";

            // 2. Altera o action do form para modo edição
            const formOrcamento = document.getElementById("formFormOrcamento") || document.getElementById("formOrcamento");
            if (formOrcamento) {
                formOrcamento.action = "php/editarOrcamento.php?id=" + idOrcamento;
            }

            // 3. Muda o título do modal
            const tituloModal = cadastroModal ? cadastroModal.querySelector("h3") : null;
            if (tituloModal) tituloModal.innerText = "Editar Orçamento #" + idOrcamento;

            // =================================================================
            // 3. PREENCHE E BLOQUEIA OS CAMPOS QUE NÃO PODEM SER EDITADOS
            // =================================================================
            
            // Campo de Busca/Nome do Cliente
            const inputCliente = document.getElementById("cliente_busca") || document.getElementById("nCliente") || document.getElementById("Cliente_idCliente");
            if (inputCliente) {
                inputCliente.value = linhaOriginal.getAttribute("data-cliente");
                inputCliente.style.pointerEvents = "none";
                inputCliente.style.backgroundColor = "#102a43"; // Deixa escurinho indicando bloqueio 
            }

            // Select/Input do Aparelho
            const nomeAparelhoCompleto = linhaOriginal.getAttribute("data-aparelho");
            const selectAparelho = document.getElementById("Aparelho_idAparelho") || document.getElementById("nAparelho") || document.getElementById("idAparelho");
            if (selectAparelho) {
                if (selectAparelho.tagName === "SELECT") {
                    // Limpa opções anteriores para não duplicar
                    selectAparelho.innerHTML = ""; 
                    
                    // Cria a opção com o texto correto ("Samsung Galaxy S20", etc.)
                    const novaOpcao = document.createElement("option");
                    novaOpcao.value = linhaOriginal.getAttribute("data-aparelho-id");
                    novaOpcao.text = nomeAparelhoCompleto;
                    novaOpcao.selected = true;
                    
                    selectAparelho.add(novaOpcao);
                } else {
                    // Se for um input de texto normal, apenas joga o valor
                    selectAparelho.value = nomeAparelhoCompleto;
                }

                // Trava o campo para não ser editado de forma alguma
                selectAparelho.style.pointerEvents = "none";
                selectAparelho.style.backgroundColor = "#102a43";
            }

            // Campo Oculto do ID do Cliente (se houver no seu sistema)
            const inputIdCliente = document.getElementById("Cliente_idCliente");
            if (inputIdCliente) {
                inputIdCliente.value = linhaOriginal.getAttribute("data-cliente-id");
            }

            // =================================================================
            // 4. PREENCHE E LIBERA OS CAMPOS PERMITIDOS (DIAG_NÓSTICO, PEÇAS, MÃO DE OBRA)
            // =================================================================
            
            // Diagnóstico
            const campoDiag = document.getElementById("diagnostico") || document.getElementById("nDiagnostico");
            if (campoDiag) {
                campoDiag.value = linhaOriginal.getAttribute("data-diagnostico");
                campoDiag.readOnly = false;
                campoDiag.style.backgroundColor = ""; // Restaura a cor padrão de digitação
            }

            // Mão de Obra
            const campoMaoObra = document.getElementById("maoObra") || document.getElementById("nMaoObra");
            if (campoMaoObra) {
                campoMaoObra.value = linhaOriginal.getAttribute("data-mao-obra");
                campoMaoObra.readOnly = false;
                campoMaoObra.style.backgroundColor = "";
            }

            // Peças
            const campoPeca = document.getElementById("peca") || document.getElementById("nPeca");
            if (campoPeca) {
                campoPeca.value = linhaOriginal.getAttribute("data-pecas");
                campoPeca.readOnly = false;
                campoPeca.style.backgroundColor = "";
            }

            // Valor Total (Preenche, mas geralmente fica travado pois depende do cálculo automático via JS)
            const campoTotal = document.getElementById("valorTotal") || document.getElementById("nValorTotal");
            if (campoTotal) {
                campoTotal.value = linhaOriginal.getAttribute("data-total");
            }

            // 5. Abre o modal
            if (cadastroModal) cadastroModal.style.display = "flex";
        });
    }


}); // FIM DO DOMCONTENTLOADED

// Mantido escopo global para o botão da tabela principal chamar a função
// Substitua completamente a sua função antiga por esta no escopo global (fim do arquivo):
function abrirModalStatus(idOrcamento) {
    const statusModal = document.getElementById("statusModal");
    const inputId = document.getElementById("statusIdOrcamento");
    
    if (statusModal && inputId) {
        inputId.value = idOrcamento; // Injeta o ID do orçamento no formulário do modal
        statusModal.style.display = "flex"; // Exibe o modal centralizado
    }
}