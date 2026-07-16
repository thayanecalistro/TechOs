document.addEventListener('DOMContentLoaded', function() {
    
    // 1. Botão de Impressão (abre a caixa de diálogo do navegador para salvar PDF)
    const btnPrint = document.querySelector('.btn-sucesso');
    if (btnPrint) {
        btnPrint.addEventListener('click', () => {
            window.print();
        });
    }

    // 2. Limpar filtros com duplo clique no formulário
    const form = document.querySelector('.search-fieldset');
    if (form) {
        form.addEventListener('dblclick', () => {
            // Redireciona para a página limpa (sem filtros na URL)
            window.location.href = 'relatorio.php';
        });
    }
});
