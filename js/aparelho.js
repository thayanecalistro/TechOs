document.addEventListener("DOMContentLoaded", function() {
    
    
    const modalAparelho = document.getElementById("modalAparelho");
    const btnAbrirNovo = document.getElementById("btnAbrirNovo");
    const btnFecharNovo = document.getElementById("btnFecharNovo");
    const btnCancelarNovo = document.getElementById("btnCancelarNovo");

    function fecharModalNovo() {
        if (modalAparelho) modalAparelho.style.display = "none";
    }

    if (btnAbrirNovo && modalAparelho) {
        btnAbrirNovo.onclick = function (e) {
            e.preventDefault();
            modalAparelho.style.display = "flex";
        };
    }

    if (btnFecharNovo) btnFecharNovo.onclick = fecharModalNovo;
    if (btnCancelarNovo) btnCancelarNovo.onclick = fecharModalNovo;


    
    const modalAlterar = document.getElementById("modalAlterarAparelho");
    const btnFecharAlterar = document.getElementById("btnFecharModalAlterar");
    const btnCancelarAlterar = document.getElementById("btnCancelarAlterar");

    function fecharModalAlterar() {
        if (modalAlterar) modalAlterar.style.display = "none";
    }

    if (btnFecharAlterar) btnFecharAlterar.onclick = fecharModalAlterar;
    if (btnCancelarAlterar) btnCancelarAlterar.onclick = fecharModalAlterar;


    
    const modalExcluir = document.getElementById("modalExcluirAparelho");
    const btnFecharExcluir = document.getElementById("btnFecharModalExcluir");
    const btnNaoExcluir = document.getElementById("btnNaoExcluir");
    const btnSimExcluir = document.getElementById("btnSimExcluir");

    function fecharModalExcluir() {
        if (modalExcluir) modalExcluir.style.display = "none";
    }

    if (btnFecharExcluir) btnFecharExcluir.onclick = fecharModalExcluir;
    if (btnNaoExcluir) btnNaoExcluir.onclick = fecharModalExcluir;


    
    window.onclick = function (e) {
        if (e.target === modalAparelho) fecharModalNovo();
        if (e.target === modalAlterar) fecharModalAlterar();
        if (e.target === modalExcluir) fecharModalExcluir();
    };


    
    document.addEventListener("click", function(e) {
        
        const btnAlterar = e.target.closest(".btn-alterar");
        if (btnAlterar) {
            e.preventDefault();
            const id = btnAlterar.getAttribute("data-id");
            const cliente = btnAlterar.getAttribute("data-cliente");
            const marca = btnAlterar.getAttribute("data-marca");
            const modelo = btnAlterar.getAttribute("data-modelo");
            const imei = btnAlterar.getAttribute("data-imei");

            if (modalAlterar) {
                const elId = document.getElementById("alt_id");
                const elCliente = document.getElementById("alt_cliente");
                const elMarca = document.getElementById("alt_marca");
                const elModelo = document.getElementById("alt_modelo");
                const elImei = document.getElementById("alt_imei");
                const formAlterar = modalAlterar.querySelector("form");

                if (elId) elId.value = id;
                if (elCliente) elCliente.value = cliente;
                if (elMarca) elMarca.value = marca;
                if (elModelo) elModelo.value = modelo;
                if (elImei) elImei.value = imei;

                if (formAlterar) {
                    formAlterar.action = "php/salvarAparelho.php?opcao=U&id=" + id;
                }

                modalAlterar.style.display = "flex";
            }
        }

        const btnExcluir = e.target.closest(".btn-excluir");
        if (btnExcluir) {
            e.preventDefault();
            const id = btnExcluir.getAttribute("data-id");
            if (modalExcluir && btnSimExcluir) {
                btnSimExcluir.href = "php/salvarAparelho.php?opcao=D&id=" + id;
                modalExcluir.style.display = "flex";
            }
        }
    });


   
    const inputPesquisar = document.getElementById('pesquisar');

    function filtrarTabelaEmTempoReal() {
        if (!inputPesquisar) return; 

        const termoBusca = inputPesquisar.value.toLowerCase().trim().replace('#', '');
        const linhasTabela = document.querySelectorAll('table tbody tr'); 

        linhasTabela.forEach(linha => {
            const colunas = linha.querySelectorAll('td');
            if (colunas.length >= 2) {
                const idDaLinha = colunas[0].textContent.toLowerCase().replace('#', '').trim();
                const nomeCliente = colunas[1].textContent.toLowerCase();

                if (termoBusca === "" || idDaLinha === termoBusca || nomeCliente.includes(termoBusca)) {
                    linha.style.display = ''; 
                } else {
                    linha.style.display = 'none'; 
                }
            }
        });
    }

    if (inputPesquisar) {
        inputPesquisar.addEventListener('keyup', filtrarTabelaEmTempoReal);
    }
});