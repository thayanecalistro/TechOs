document.addEventListener("DOMContentLoaded", function () {
    const modal = document.getElementById("cadastroModal");
    const btnNovo = document.getElementById("btnNovoOrcamento");
    const btnFechar = document.getElementById("btnFecharModal");
    
    const containerPecas = document.getElementById("container-pecas");
    const btnAdicionarPeca = document.getElementById("btnAdicionarPeca");
    const inputMaoObra = document.getElementById("maoObra");
    const inputValorTotal = document.getElementById("valorTotal");

    if (btnNovo) {
        btnNovo.addEventListener("click", () => modal.style.display = "flex");
    }

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
}); // FIM DO DOMCONTENTLOADED

// Mantido escopo global para o botão da tabela principal chamar a função
function alterarStatusOrcamento(idOrcamento, novoStatus) {
    if(confirm("Deseja alterar o status deste orçamento para " + novoStatus + "?")) {
        window.location.href = "php/atualizarStatus.php?id=" + idOrcamento + "&status=" + novoStatus;
    }
}