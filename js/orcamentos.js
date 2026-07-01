document.addEventListener("DOMContentLoaded", function () {
    const modal = document.getElementById("cadastroModal");
    const btnNovo = document.getElementById("btnNovoOrcamento");
    const btnFechar = document.getElementById("btnFecharModal");
    
    // Elementos de cálculo de valor
    const inputValorUni = document.getElementById("valorUni");
    const inputMaoObra = document.getElementById("maoObra");
    const inputValorTotal = document.getElementById("valorTotal");

    // Abrir Modal
    btnNovo.addEventListener("click", function () {
        modal.style.display = "flex";
    });

    // Fechar Modal
    btnFechar.addEventListener("click", function () {
        modal.style.display = "none";
        document.getElementById("formOrcamento").reset();
    });

    // Fechar ao clicar fora do modal
    window.addEventListener("click", function (event) {
        if (event.target === modal) {
            modal.style.display = "none";
            document.getElementById("formOrcamento").reset();
        }
    });

    // Função para calcular o valor total automaticamente
    function calcularTotal() {
        const valorUni = parseFloat(inputValorUni.value) || 0;
        const maoObra = parseFloat(inputMaoObra.value) || 0;
        const total = valorUni + maoObra;
        
        inputValorTotal.value = total.toFixed(2);
    }

    // Ouvintes para recalcular sempre que o usuário digitar nos campos financeiros
    inputValorUni.addEventListener("input", calcularTotal);
    inputMaoObra.addEventListener("input", calcularTotal);
});

document.getElementById('cliente_busca').addEventListener('input', function() {
    var inputVisivel = this;
    var inputEscondido = document.getElementById('Cliente_idCliente');
    var datalist = document.getElementById('listaClientes');
    
    // Procura na datalist se o texto digitado bate com alguma opção
    var opcaoSelecionada = Array.from(datalist.options).find(function(option) {
        return option.value === inputVisivel.value;
    });

    if (opcaoSelecionada) {
        // Se achou o nome, joga o ID correspondente no input oculto
        inputEscondido.value = opcaoSelecionada.getAttribute('data-id');
    } else {
        // Se o usuário apagar ou digitar algo que não existe, limpa o ID
        inputEscondido.value = "";
    }
});

// Monitora as mudanças no input oculto do ID do cliente (que criamos no passo anterior)
const inputClienteId = document.getElementById('Clientes_idCliente');
const selectAparelho = document.getElementById('Aparelho_idAparelho');

// Criamos um observador para detectar quando o valor do ID mudar via script
const observer = new MutationObserver(function(mutations) {
    mutations.forEach(function(mutation) {
        if (mutation.attributeName === 'value') {
            carregarAparelhosDoCliente(inputClienteId.value);
        }
    });
});

// Ativa o observador no input do ID do cliente
if (inputClienteId) {
    observer.observe(inputClienteId, { attributes: true });
}

// Função que faz a requisição Ajax (Fetch API) para buscar os aparelhos
function carregarAparelhosDoCliente(idCliente) {
    if (!idCliente) {
        selectAparelho.innerHTML = "<option value=''>Selecione primeiro o cliente...</option>";
        return;
    }

    selectAparelho.innerHTML = "<option value=''>Carregando aparelhos...</option>";

    // Faz a chamada assíncrona para o arquivo PHP
    fetch('buscar_aparelhos.php?idCliente=' + idCliente)
        .then(response => response.text())
        .then(html => {
            selectAparelho.innerHTML = html;
        })
        .catch(error => {
            console.error('Erro ao buscar aparelhos:', error);
            selectAparelho.innerHTML = "<option value=''>Erro ao carregar aparelhos</option>";
        });
}