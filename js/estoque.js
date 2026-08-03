// 1. Calcula o total na tela dinamicamente
function calcularTotal() {
    const valorInput = document.getElementById('valor');
    const qtdInput = document.getElementById('qtd');
    const totalInput = document.getElementById('total');

    if (valorInput && qtdInput && totalInput) {
        const valor = parseFloat(valorInput.value) || 0;
        const qtd = parseInt(qtdInput.value) || 0;
        totalInput.value = (valor * qtd).toFixed(2);
    }
}

// 2. Abertura do Modal de Cadastro (Novo Item)
function abrirModalEstoque() {
    const form = document.getElementById('formEstoque');
    if (form) form.reset();

    const titulo = document.getElementById('tituloModalEstoque');
    if (titulo) titulo.innerText = "Novo Item no Estoque";

    const idInput = document.getElementById('idEstoque');
    if (idInput) idInput.value = "";

    const totalInput = document.getElementById('total');
    if (totalInput) totalInput.value = "";

    const modal = document.getElementById('modalEstoque');
    if (modal) modal.style.display = 'flex';
}

// 3. Fechamento dos Modais
function fecharModalEstoque() {
    const modal = document.getElementById('modalEstoque');
    if (modal) {
        modal.style.display = 'none';
    }
    const form = document.getElementById('formEstoque');
    if (form) form.reset();
}

function fecharModalVisualizarEstoque() {
    const modal = document.getElementById('modalEstoqueVisualizar');
    if (modal) {
        modal.style.display = 'none';
    }
}

// Torna as funções globais para funcionarem via onclick no HTML
window.calcularTotal = calcularTotal;
window.abrirModalEstoque = abrirModalEstoque;
window.fecharModalEstoque = fecharModalEstoque;
window.fecharModalVisualizarEstoque = fecharModalVisualizarEstoque;

// 4. Controle de Eventos da Tela
document.addEventListener('DOMContentLoaded', function() {

    // Listener de cliques delegado no documento
    document.addEventListener('click', function(e) {
        
        // --- AÇÃO DO BOTÃO EDITAR ---
        const botaoEditar = e.target.closest('.btn-alterar, .acao-editar');
        if (botaoEditar) {
            e.preventDefault();
            const titulo = document.getElementById('tituloModalEstoque');
            if (titulo) titulo.innerText = "Alterar Item no Estoque";

            if (document.getElementById('idEstoque')) document.getElementById('idEstoque').value = botaoEditar.getAttribute('data-id') || "";
            if (document.getElementById('NomeFornecedor')) document.getElementById('NomeFornecedor').value = botaoEditar.getAttribute('data-fornecedor') || "";
            if (document.getElementById('peca')) document.getElementById('peca').value = botaoEditar.getAttribute('data-peca') || "";
            if (document.getElementById('valor')) document.getElementById('valor').value = botaoEditar.getAttribute('data-valor') || "";
            if (document.getElementById('qtd')) document.getElementById('qtd').value = botaoEditar.getAttribute('data-quantidade') || "";
            if (document.getElementById('total')) document.getElementById('total').value = botaoEditar.getAttribute('data-total') || "";

            const modal = document.getElementById('modalEstoque');
            if (modal) modal.style.display = 'flex';
            return;
        }

        // --- AÇÃO DO BOTÃO VISUALIZAR ---
        const botaoVisualizar = e.target.closest('.btn-visualizar');
        if (botaoVisualizar) {
            e.preventDefault();
            const id = botaoVisualizar.getAttribute('data-id') || "";
            const fornecedor = botaoVisualizar.getAttribute('data-fornecedor') || "";
            const peca = botaoVisualizar.getAttribute('data-peca') || "";
            const valorRaw = parseFloat(botaoVisualizar.getAttribute('data-valor') || 0);
            const qtd = botaoVisualizar.getAttribute('data-quantidade') || "0";
            const totalRaw = parseFloat(botaoVisualizar.getAttribute('data-total') || 0);

            const valorFormatado = valorRaw.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
            const totalFormatado = totalRaw.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });

            if (document.getElementById('txtIdEstoque')) document.getElementById('txtIdEstoque').innerText = id;
            if (document.getElementById('txtFornecedorEstoque')) document.getElementById('txtFornecedorEstoque').innerText = fornecedor;
            if (document.getElementById('txtPecaEstoque')) document.getElementById('txtPecaEstoque').innerText = peca;
            if (document.getElementById('txtValorEstoque')) document.getElementById('txtValorEstoque').innerText = valorFormatado;
            if (document.getElementById('txtQtdEstoque')) document.getElementById('txtQtdEstoque').innerText = qtd;
            if (document.getElementById('txtTotalEstoque')) document.getElementById('txtTotalEstoque').innerText = totalFormatado;

            const modalVis = document.getElementById('modalEstoqueVisualizar');
            if (modalVis) modalVis.style.display = 'flex';
            return;
        }
    });

    // Fechar modais ao clicar no fundo escuro fora da caixa
    window.addEventListener('click', function(event) {
        const modalCad = document.getElementById('modalEstoque');
        const modalVis = document.getElementById('modalEstoqueVisualizar');

        if (event.target === modalCad) fecharModalEstoque();
        if (event.target === modalVis) fecharModalVisualizarEstoque();
    });

    // Ativa a tecla ENTER no campo de pesquisa
    const inputPesquisar = document.getElementById('pesquisar');
    if (inputPesquisar) {
        inputPesquisar.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                const formBusca = document.getElementById('formBusca');
                if (formBusca) formBusca.submit();
            }
        });
    }

});