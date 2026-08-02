// js/estoque.js

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

// 2. Controla o preenchimento dos campos assincronamente
document.addEventListener('DOMContentLoaded', function() {
    
    // Captura ação do botão Editar na tabela
    const botoesEditar = document.querySelectorAll('.acao-editar');
    botoesEditar.forEach(botao => {
        botao.addEventListener('click', function() {
            const titulo = document.getElementById('tituloModalEstoque');
            if(titulo) titulo.innerText = "Alterar Item no Estoque";
            
            // Preenche os inputs do modal com os dados extraídos do botão da linha
            document.getElementById('idEstoque').value = this.getAttribute('data-id') || "";
            document.getElementById('NomeFornecedor').value = this.getAttribute('data-fornecedor') || "";
            document.getElementById('peca').value = this.getAttribute('data-peca') || "";
            document.getElementById('valor').value = this.getAttribute('data-valor') || "";
            document.getElementById('qtd').value = this.getAttribute('data-quantidade') || "";
            document.getElementById('total').value = this.getAttribute('data-total') || "";
            
            // Abre a instância do modal nativo Bootstrap 5
            const modalElement = document.getElementById('modalEstoque');
            const meuModal = bootstrap.Modal.getOrCreateInstance(modalElement);
            meuModal.show();
        });
    });

    // Garante o comportamento correto ao clicar em "Novo Item"
    const btnNovo = document.querySelector('[data-bs-target="#modalEstoque]');
    if (btnNovo) {
        btnNovo.addEventListener('click', function() {
            const titulo = document.getElementById('tituloModalEstoque');
            if(titulo) titulo.innerText = "Novo Item no Estoque";
            
            // Efetua a limpeza controlada preventiva de resquícios de edição anterior
            if(document.getElementById('idEstoque')) document.getElementById('idEstoque').value = "";
            if(document.getElementById('Cliente_idCliente')) document.getElementById('Cliente_idCliente').value = "";
            if(document.getElementById('NomeFornecedor')) document.getElementById('NomeFornecedor').value = "";
            if(document.getElementById('peca')) document.getElementById('peca').value = "";
            if(document.getElementById('valor')) document.getElementById('valor').value = "";
            if(document.getElementById('qtd')) document.getElementById('qtd').value = "";
            if(document.getElementById('total')) document.getElementById('total').value = "0.00";
        });
    }
});