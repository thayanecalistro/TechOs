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
    
    // Captura ação do botão Editar na tabela usando delegação de eventos
    // (Melhor prática já que as linhas vêm prontas da função PHP)
    document.body.addEventListener('click', function(e) {
        const botaoEditar = e.target.closest('.acao-editar');
        
        if (botaoEditar) {
            const titulo = document.getElementById('tituloModalEstoque');
            if(titulo) titulo.innerText = "Alterar Item no Estoque";
            
            // Preenche os inputs do modal com os dados extraídos do botão da linha
            document.getElementById('idEstoque').value = botaoEditar.getAttribute('data-id') || "";
            document.getElementById('NomeFornecedor').value = botaoEditar.getAttribute('data-fornecedor') || "";
            document.getElementById('peca').value = botaoEditar.getAttribute('data-peca') || "";
            document.getElementById('valor').value = botaoEditar.getAttribute('data-valor') || "";
            document.getElementById('qtd').value = botaoEditar.getAttribute('data-quantidade') || "";
            document.getElementById('total').value = botaoEditar.getAttribute('data-total') || "";
            
            // Abre a instância do modal nativo Bootstrap 5
            const modalElement = document.getElementById('modalEstoque');
            const meuModal = bootstrap.Modal.getOrCreateInstance(modalElement);
            meuModal.show();
        }
    });

    // Garante o comportamento correto ao clicar em "Novo Item"
    const btnNovo = document.querySelector('[data-bs-target="#modalEstoque"]');
    if (btnNovo) {
        btnNovo.addEventListener('click', function() {
            const titulo = document.getElementById('tituloModalEstoque');
            if(titulo) titulo.innerText = "Novo Item no Estoque";
            
            // Limpa o formulário completamente para evitar resquícios de edições anteriores
            const form = document.getElementById('formEstoque');
            if(form) form.reset();
            
            // Garante que o ID oculto fique vazio (indica inserção nova)
            if(document.getElementById('idEstoque')) document.getElementById('idEstoque').value = "";
            if(document.getElementById('total')) document.getElementById('total').value = "0.00";
        });
    }
});