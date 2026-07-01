document.addEventListener("DOMContentLoaded", function() {
    const btnFiltrar = document.getElementById("btnFiltrar");
    const btnExportar = document.getElementById("btnExportar");

    // Lógica para clique no botão de filtragem (para futuras requisições Ajax)
    if (btnFiltrar) {
        btnFiltrar.addEventListener("click", function() {
            const modulo = document.getElementById("filtroModulo").value;
            const dataInicio = document.getElementById("dataInicio").value;
            const dataFim = document.getElementById("dataFim").value;
            
            console.log('Filtrando por Módulo: ${modulo} | Período: ${dataInicio} até ${dataFim}');
            // Aqui você poderá implementar seu carregamento assíncrono via fetch ou submit
        });
    }

    // Ação simples de exportação (Abre o gerenciador de impressão nativo configurado para PDF)
    if (btnExportar) {
        btnExportar.addEventListener("click", function() {
            window.print();
        });
    }
});