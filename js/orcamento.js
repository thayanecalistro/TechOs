document.addEventListener("DOMContentLoaded", function () {
    const modal = document.getElementById("cadastroModal");
    const btnNovo = document.getElementById("btnNovoOrcamento");
    const btnFechar = document.getElementById("btnFecharModal");
    
    const containerPecas = document.getElementById("container-pecas");
    const btnAdicionarPeca = document.getElementById("btnAdicionarPeca");
    const inputMaoObra = document.getElementById("maoObra");
    const inputValorTotal = document.getElementById("valorTotal");

    btnNovo.addEventListener("click", () => modal.style.display = "flex");

    // Correção na estrutura inicial do modal (garante datalist e classes no primeiro item ao resetar)
    const fecharEResetarModal = () => {
        modal.style.display = "none";
        document.getElementById("formOrcamento").reset();
        containerPecas.innerHTML = `
            <div class="peca-row" style="display: flex; gap: 10px; margin-bottom: 10px;">
                <input type="text" class="classe-busca-peca" list="listaPecasEstoque" placeholder="Busque a peça no estoque..." style="flex: 2;" required autocomplete="off">
                <input type="hidden" name="nIdEstoque[]" class="classe-id-estoque">
                <input type="number" name="nValorUni[]" class="classe-val-uni" step="0.01" value="0.00" style="flex: 1;" readonly>
                <input type="number" name="nQtd[]" class="classe-qtd" value="1" min="1" style="width: 70px;">
            </div>
        `;
        inputValorTotal.value = "0.00";
    };

    btnFechar.addEventListener("click", fecharEResetarModal);
    window.addEventListener("click", (e) => { if (e.target === modal) fecharEResetarModal(); });

    // Adiciona nova linha de peça mantendo a integração
    btnAdicionarPeca.addEventListener("click", function () {
        const novaLinha = document.createElement("div");
        novaLinha.className = "peca-row";
        novaLinha.style = "display: flex; gap: 10px; margin-bottom: 10px;";
        novaLinha.innerHTML = `
            <input type="text" class="classe-busca-peca" list="listaPecasEstoque" placeholder="Busque a peça no estoque..." style="flex: 2;" required autocomplete="off">
            <input type="hidden" name="nIdEstoque[]" class="classe-id-estoque">
            <input type="number" name="nValorUni[]" class="classe-val-uni" step="0.01" value="0.00" style="flex: 1;" readonly>
            <input type="number" name="nQtd[]" class="classe-qtd" value="1" min="1" style="width: 70px;">
            <button type="button" class="btn btn-red btn-remover-linha" style="padding: 0 10px; height: 35px;">X</button>
        `;
        containerPecas.appendChild(novaLinha);
    });

    // Listener dinâmico para preenchimento de preço ao escolher a peça
    containerPecas.addEventListener("input", function (e) {
        if (e.target.classList.contains("classe-busca-peca")) {
            const inputBusca = e.target;
            const linha = inputBusca.closest(".peca-row");
            const datalist = document.getElementById("listaPecasEstoque");
            
            // Procura a opção correspondente ao texto selecionado
            const opcao = Array.from(datalist.options).find(o => o.value === inputBusca.value);
            
            if (opcao) {
                linha.querySelector(".classe-id-estoque").value = opcao.getAttribute("data-id");
                linha.querySelector(".classe-val-uni").value = parseFloat(opcao.getAttribute("data-valor")).toFixed(2);
            } else {
                linha.querySelector(".classe-id-estoque").value = "";
                linha.querySelector(".classe-val-uni").value = "0.00";
            }
        }
        // Independente do que mudou (peça ou quantidade), refaz a conta total
        calcularTotal();
    });

    containerPecas.addEventListener("click", function (e) {
        if (e.target.classList.contains("btn-remover-linha")) {
            e.target.parentElement.remove();
            calcularTotal();
        }
    });

    // O PULO DO GATO: Vincula a alteração da Mão de Obra à função de calcular
    if (inputMaoObra) {
        inputMaoObra.addEventListener("input", calcularTotal);
        inputMaoObra.addEventListener("change", calcularTotal); // Para cliques nas setas numéricas
    }

    function calcularTotal() {
        let subtotalPecas = 0;
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

        // 2. Captura e limpa o valor da Mão de Obra (Trata R$, espaços e vírgulas)
        let textoMaoObra = inputMaoObra ? inputMaoObra.value : "0";
        textoMaoObra = textoMaoObra.replace("R$", "").replace(/\s/g, "").replace(",", ".");
        const maoObra = parseFloat(textoMaoObra) || 0;

        // 3. Atualiza o input de valor total na tela
        if (inputValorTotal) {
            inputValorTotal.value = (subtotalPecas + maoObra).toFixed(2);
        }
    }

    if (inputMaoObra) {
        // O segredo está em usar múltiplos eventos para garantir que qualquer mudança chame a soma
        inputMaoObra.addEventListener("input", calcularTotal);
        inputMaoObra.addEventListener("keyup", calcularTotal);
        inputMaoObra.addEventListener("change", calcularTotal);
        inputMaoObra.addEventListener("blur", calcularTotal); // Executa quando você clica fora do campo
    }

// Mecanismo AJAX para preenchimento dos aparelhos do cliente
document.getElementById('cliente_busca').addEventListener('input', function() {
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

function alterarStatusOrcamento(idOrcamento, novoStatus) {
    if(confirm("Deseja alterar o status deste orçamento para " + novoStatus + "?")) {
        window.location.href = "php/atualizarStatus.php?id=" + idOrcamento + "&status=" + novoStatus;
    }
}