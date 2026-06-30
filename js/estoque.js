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

// 2. Controla o preenchimento dos campos
document.addEventListener('DOMContentLoaded', function() {
    
    // Captura ação do botão Editar na tabela
    const botoesEditar = document.querySelectorAll('.acao-editar');
    botoesEditar.forEach(botao => {
        botao.addEventListener('click', function() {
            document.getElementById('tituloModalEstoque').innerText = "Alterar Item no Estoque";
            
            // Preenche os inputs do modal com os dados da tabela
            document.getElementById('idEstoque').value = this.getAttribute('data-id');
            document.getElementById('NomeFornecedor').value = this.getAttribute('data-fornecedor');
            document.getElementById('peca').value = this.getAttribute('data-peca');
            document.getElementById('valor').value = this.getAttribute('data-valor');
            document.getElementById('qtd').value = this.getAttribute('data-quantidade');
            document.getElementById('total').value = this.getAttribute('data-total');
            
            // Abre o modal
            const modalElement = document.getElementById('modalEstoque');
            const meuModal = bootstrap.Modal.getOrCreateInstance(modalElement);
            meuModal.show();
        });
    });

    // Modificado: Garante que o botão Novo limpe APENAS os valores dos inputs
    const btnNovo = document.querySelector('.btn-novo');
    if (btnNovo) {
        btnNovo.addEventListener('click', function() {
            // Define o título do modal
            document.getElementById('tituloModalEstoque').innerText = "Novo Item no Estoque";
            
            // Limpa o valor de cada campo individualmente por segurança (sem resetar o HTML dos títulos)
            if(document.getElementById('idEstoque')) document.getElementById('idEstoque').value = "";
            if(document.getElementById('NomeFornecedor')) document.getElementById('NomeFornecedor').value = "";
            if(document.getElementById('peca')) document.getElementById('peca').value = "";
            if(document.getElementById('valor')) document.getElementById('valor').value = "";
            if(document.getElementById('qtd')) document.getElementById('qtd').value = "";
            if(document.getElementById('total')) document.getElementById('total').value = "";
        });
    }
});