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
            document.getElementById("viewPecas").value = pecas || "Sem peças vinculadas";
            document.getElementById("viewMaoObra").value = maoObra ? Number(maoObra).toFixed(2) : "0.00";
            document.getElementById("viewTotal").value = total ? Number(total).toFixed(2) : "0.00";
            document.getElementById("viewStatus").value = status || "";

            // Exibe o modal
            detalhesModal.style.display = "flex";
        });
    }

    // =========================================================================
    // AÇÃO DO BOTÃO EXCLUIR (DENTRO DO MODAL DE DETALHES)
    // =========================================================================
    const btnAcaoExcluir = document.getElementById("btnAcaoExcluir");

    if (btnAcaoExcluir) {
        btnAcaoExcluir.addEventListener("click", function () {
            // Pega o ID que está sendo exibido no título do modal (ex: "#15" -> "15")
            const idTexto = document.getElementById("viewIdOrcamento").innerText;
            const idOrcamento = idTexto.replace("#", "").trim();

            if (!idOrcamento) {
                alert("Erro: ID do orçamento não encontrado.");
                return;
            }

            // Mensagem de confirmação solicitada
            const confirmar = confirm("Deseja realmente excluir o orçamento #" + idOrcamento + "? Esta ação não poderá ser desfeita."); 
            
            if (confirmar) {
                // Redireciona para o arquivo processador passando a ação e o ID por parâmetro
                window.location.href = php/processarAcoes.php?acao=excluir&id=$idOrcamento;
            }
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