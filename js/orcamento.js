document.addEventListener("DOMContentLoaded", function () {
    const modal = document.getElementById("cadastroModal");
    const btnNovo = document.getElementById("btnNovoOrcamento");
    const btnFechar = document.getElementById("btnFecharModal");
    
    const containerPecas = document.getElementById("container-pecas");
    const btnAdicionarPeca = document.getElementById("btnAdicionarPeca");
    const inputMaoObra = document.getElementById("maoObra");
    const inputValorTotal = document.getElementById("valorTotal");

    btnNovo.addEventListener("click", () => modal.style.display = "flex");

    const fecharEResetarModal = () => {
        modal.style.display = "none";
        document.getElementById("formOrcamento").reset();
        containerPecas.innerHTML = `
            <div class="peca-row" style="display: flex; gap: 10px; margin-bottom: 10px;">
                <input type="text" name="nPeca[]" placeholder="Nome ou descrição da peça..." style="flex: 2;" required>
                <input type="number" name="nValorUni[]" class="classe-val-uni" step="0.01" value="0.00" style="flex: 1;">
                <input type="number" name="nQtd[]" class="classe-qtd" value="1" min="1" style="width: 70px;">
            </div>
        `;
        inputValorTotal.value = "0.00";
    };

    btnFechar.addEventListener("click", fecharEResetarModal);
    window.addEventListener("click", (e) => { if (e.target === modal) fecharEResetarModal(); });

    // ... (mantenha os seletores de abrir/fechar modal que já funcionam)

// Adiciona nova linha de peça mantendo a integração
btnAdicionarPeca.addEventListener("click", function () {
    const novaLinha = document.createElement("div");
    novaLinha.className = "peca-row";
    novaLinha.style = "display: flex; gap: 10px; margin-bottom: 10px;";
    novaLinha.innerHTML = `
        <input type="text" class="classe-busca-peca" list="listaPecasEstoque" placeholder="Busque a peça no estoque..." style="flex: 2;" required autocomplete="off">
        <input type="hidden" name="nIdEstoque[]" class="classe-id-estoque">
        <input type="number" name="nValorUni[]" class="classe-val-uni" step="0.01" value="0.00" style="flex: 1;" readonly style="background-color: #0c1f32; color: #2cb1bc;">
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

    function calcularTotal() {
        let subtotalPecas = 0;
        const linhas = containerPecas.querySelectorAll(".peca-row");
        
        linhas.forEach(linha => {
            const valUni = parseFloat(linha.querySelector(".classe-val-uni").value) || 0;
            const qtd = parseInt(linha.querySelector(".classe-qtd").value) || 1;
            subtotalPecas += (valUni * qtd);
        });

        const maoObra = parseFloat(inputMaoObra.value) || 0;
        inputValorTotal.value = (subtotalPecas + maoObra).toFixed(2);
    }
});

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