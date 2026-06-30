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