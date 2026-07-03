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
    var selectAparelho = document.getElementById('Aparelho_idAparelho');
    
    // Procura na datalist se o texto digitado bate com alguma opção
    var opcaoSelecionada = Array.from(datalist.options).find(function(option) {
        return option.value === inputVisivel.value;
    });

    if (opcaoSelecionada) {
        // Se achou o nome, joga o ID correspondente no input oculto
        var idCliente = opcaoSelecionada.getAttribute('data-id');
        inputEscondido.value = idCliente;

        // Avisa o usuário que os dados estão sendo buscados
        selectAparelho.innerHTML = "<option value=''>Carregando aparelhos...</option>";

        // Faz a requisição AJAX para buscar os aparelhos do cliente selecionado
        fetch('php/buscar_aparelhos.php?cliente_id=' + idCliente)
            .then(response => response.text())
            .then(html => {
                selectAparelho.innerHTML = html; // Preenche o <select> com o resultado do PHP
            })
            .catch(error => {
                console.error('Erro ao buscar aparelhos:', error);
                selectAparelho.innerHTML = "<option value=''>Erro ao carregar aparelhos</option>";
            });

    } else {
        // Se o usuário apagar o nome ou digitar algo inválido, limpa tudo
        inputEscondido.value = "";
        selectAparelho.innerHTML = "<option value=''>Selecione primeiro o cliente...</option>";
    }
});


